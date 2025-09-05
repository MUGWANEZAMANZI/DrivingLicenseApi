<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\License;
use App\Models\Card;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RegisterDriverController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surName' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:drivers,phone',
            'email' => 'required|string|email|max:255|unique:drivers,email',
            'address' => 'required|string|max:500',
            'bloodGroup' => 'required|string|max:3',
            'nationalId' => 'required|string|max:20|unique:drivers,nationalId',
            'licenseNumber' => 'required|string|max:50|unique:licenses,licenseNumber',
            'issueDate' => 'required|date',
            'expiryDate' => 'required|date|after:issueDate',
            'plateNumber' => 'required|string|max:20|unique:licenses,plateNumber',
            'profileImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);

        $profileImagePath = null;
        if ($request->hasFile('profileImage')) {
            $profileImagePath = $request->file('profileImage')->store('profile_images', 'public');
        }

        // Create Driver
        $driver = Driver::create([
            'name' => $validatedData['name'],
            'surName' => $validatedData['surName'],
            'phone' => $validatedData['phone'],
            'email' => $validatedData['email'],
            'address' => $validatedData['address'],
            'bloodGroup' => $validatedData['bloodGroup'],
            'nationalId' => $validatedData['nationalId'],
            'profileImage' => $profileImagePath,
        ]);

        if(!$driver) {
            return response()->json(['message' => 'Driver registration failed'], 500);
        }

        // Create License
        $license = License::create([
            'driverId' => $driver->id,
            'licenseNumber' => $validatedData['licenseNumber'],
            'issueDate' => $validatedData['issueDate'],
            'expiryDate' => $validatedData['expiryDate'],
            'plateNumber' => $validatedData['plateNumber'],
        ]);


        if(!$license) {
            return response()->json(['message' => 'License registration failed'], 500);
        }

        return response()->json(['message' => 'Driver and License registered successfully'], 201);
    }

    public function UpdateDriver(Request $request, $id)
    {
        $driver = Driver::find($id);
        if (!$driver) {
            return response()->json(['message' => 'Driver not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'surName' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes|required|string|max:20|unique:drivers,phone,' . $driver->id,
            'email' => 'sometimes|required|string|email|max:255|unique:drivers,email,' . $driver->id,
            'address' => 'sometimes|required|string|max:500',
            'bloodGroup' => 'sometimes|required|string|max:3',
            'nationalId' => 'sometimes|required|string|max:20|unique:drivers,nationalId,' . $driver->id,
        ]);

        $driver->update($validatedData);

        return response()->json(['message' => 'Driver updated successfully'], 200);
    }


    public function verifyLicense(Request $request, $id)
    {
        $driver = Driver::find($id);
        if (!$driver) {
            return response()->json(['message' => 'Driver not found'], 404);
        }

        $license = $driver->license;
        if (!$license) {
            return response()->json(['message' => 'License not found'], 404);
        }

        $currentDate = now();
        if ($license->expiryDate < $currentDate) {
            return response()->json(['message' => 'License has expired'], 400);
        }

        return response()->json(['message' => 'License is valid'], 200);
    }

    // Helper to format driver response (with optional QR code)
    private function formatDriverResponse($driver, $license, $qrCode = null) {
        $response = [
            'name' => $driver->name,
            'surName' => $driver->surName,
            'licenseId' => $license->licenseNumber,
            'plate' => $license->plateNumber,
            'bloodGroup' => $driver->bloodGroup,
            'issue' => $license->issueDate,
            'expiry' => $license->expiryDate,
            'nationalId' => $driver->nationalId,
            'profileImage' => $driver->profileImage,
        ];
        if ($qrCode) {
            $response['qrCode'] = $qrCode;
        }
        return $response;
    }

    public function printCard(Request $request, $id)
    {
        $driver = Driver::find($id);
        if (!$driver) {
            return response()->json(['error' => 'Driver not found'], 404);
        }
        $license = $driver->license;
        if (!$license) {
            return response()->json(['error' => 'License not found'], 404);
        }
        try {
            $secret = bin2hex(random_bytes(32)); // 64 hex digits
            $card = Card::create([
                'license_id' => $license->id,
                'cardNumber' => 'CARD-' . strtoupper(uniqid()),
                'secret' => $secret,
                'programmedDate' => now()->toDateString(),
            ]);
            $qrData = [
                'licenseNumber' => $license->licenseNumber,
                'cardNumber' => $card->cardNumber,
                'secret' => $secret,
            ];
            $qrString = json_encode($qrData);
            $qrCode = base64_encode(QrCode::format('png')->size(200)->generate($qrString));
            return response()->json([
                'card' => $card,
                'qrCode' => $qrCode,
                'qrData' => $qrData,
                'message' => 'Card printed and secret generated.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error printing card', 'error' => $e->getMessage()], 500);
        }
    }

    // Search driver by license number or plate
    public function driverSearch(Request $request)
    {
        $query = $request->query('query');
        if (!$query) {
            return response()->json(['error' => 'Query is required.'], 400);
        }
        $license = License::where('licenseNumber', $query)
            ->orWhere('plateNumber', $query)
            ->first();
        if (!$license) {
            return response()->json(['error' => 'Aucun conducteur trouvé.'], 404);
        }
        $driver = $license->driver;
        return response()->json($this->formatDriverResponse($driver, $license));
    }

    // Search driver by card number (NFC)
    public function driverByCard($cardNumber)
    {
        $card = Card::where('cardNumber', $cardNumber)->first();
        if (!$card) {
            return response()->json(['error' => 'Aucun conducteur trouvé pour cette carte.'], 404);
        }
        $license = License::find($card->license_id);
        if (!$license) {
            return response()->json(['error' => 'Aucun conducteur trouvé pour cette carte.'], 404);
        }
        $driver = $license->driver;
        return response()->json($this->formatDriverResponse($driver, $license));
    }

    // Search driver by QR code (expects base64 encoded JSON string)
    public function driverByQr($qrData)
    {
        $decoded = json_decode(base64_decode($qrData), true);
        if (!$decoded || !isset($decoded['driver']['nationalId'])) {
            return response()->json(['error' => 'QR code invalide.'], 400);
        }
        $driver = Driver::where('nationalId', $decoded['driver']['nationalId'])->first();
        if (!$driver) {
            return response()->json(['error' => 'Aucun conducteur trouvé pour ce QR code.'], 404);
        }
        $license = $driver->license;
        return response()->json($this->formatDriverResponse($driver, $license));
    }

    public function saveCardSvg(Request $request)
    {
        $request->validate([
            'svgFront' => 'required|string',
            'svgBack' => 'required|string',
            'nationalId' => 'required|string|exists:drivers,nationalId',
        ]);
        $driver = Driver::where('nationalId', $request->nationalId)->first();
        if (!$driver) {
            return response()->json(['error' => 'Driver not found'], 404);
        }
        $license = $driver->license;
        if (!$license) {
            return response()->json(['error' => 'License not found'], 404);
        }
        $card = Card::where('license_id', $license->id)->latest()->first();
        if (!$card) {
            $card = Card::create([
                'license_id' => $license->id,
                'cardNumber' => 'CARD-' . strtoupper(uniqid()),
                'programmedDate' => now()->toDateString(),
            ]);
        }
        // Store SVGs in storage/app/public/cards/{cardNumber}_front.svg and _back.svg
        $frontPath = 'cards/' . $card->cardNumber . '_front.svg';
        $backPath = 'cards/' . $card->cardNumber . '_back.svg';
        \Storage::disk('public')->put($frontPath, $request->svgFront);
        \Storage::disk('public')->put($backPath, $request->svgBack);
        return response()->json(['message' => 'SVGs saved', 'cardNumber' => $card->cardNumber]);
    }

    public function saveCardTag(Request $request)
    {
        $request->validate([
            'tagId' => 'required|string',
            'nationalId' => 'required|string|exists:drivers,nationalId',
        ]);
        $driver = Driver::where('nationalId', $request->nationalId)->first();
        if (!$driver) {
            return response()->json(['error' => 'Driver not found'], 404);
        }
        $license = $driver->license;
        if (!$license) {
            return response()->json(['error' => 'License not found'], 404);
        }
        $card = Card::where('license_id', $license->id)->latest()->first();
        if (!$card) {
            $card = Card::create([
                'license_id' => $license->id,
                'cardNumber' => 'CARD-' . strtoupper(uniqid()),
                'programmedDate' => now()->toDateString(),
            ]);
        }
        $card->cardNumber = $request->tagId;
        $card->save();
        return response()->json(['message' => 'Card tag saved', 'cardNumber' => $card->cardNumber]);
    }
}
