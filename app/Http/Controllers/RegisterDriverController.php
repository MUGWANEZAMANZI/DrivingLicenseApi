<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\License;
use App\Models\Card;

class RegisterDriverController extends Controller
{
    public function register(Request $request)
    {
        \Log::info('Registering driver - request received', $request->all());
        // Map frontend keys to backend keys (support both surName and surname)
        $input = $request->all();
        $input['surName'] = $input['surName'] ?? $input['surname'] ?? null;
        $input['licenseNumber'] = $input['licenseNumber'] ?? $input['licenseId'] ?? null;
        $input['plateNumber'] = $input['plateNumber'] ?? $input['plate'] ?? null;
        $input['issueDate'] = $input['issueDate'] ?? $input['issue'] ?? null;
        $input['expiryDate'] = $input['expiryDate'] ?? $input['expiry'] ?? null;
        unset($input['surname'], $input['licenseId'], $input['plate'], $input['issue'], $input['expiry']);
        try {
            $validatedData = validator($input, [
                'name' => 'required|string|max:255',
                'surName' => 'required|string|max:255',
                'phone' => 'required|string|max:20|unique:drivers,phone',
                'email' => 'required|string|email|max:255|unique:drivers,email',
                'address' => 'required|string|max:500',
                'bloodGroup' => 'required|string|max:3',
                'nationalId' => 'required|string|max:20|unique:drivers,nationalId',
                'nationality' => 'nullable|string|max:100',
                'licenseNumber' => 'required|string|max:50|unique:licenses,licenseNumber',
                'issueDate' => 'required|date',
                'expiryDate' => 'required|date|after:issueDate',
                'plateNumber' => 'required|string|max:20|unique:licenses,plateNumber',
                'profileImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'nfcTag' => 'nullable|string|max:255',
                'secret' => 'nullable|string|max:255',
//                'licensesAllowed' => 'nullable|string|max:255',
                'dateLieuDelivrance' => 'nullable|string|max:255',
                'allowedCategories' => 'nullable|string|max:255',
            ])->validate();
            \Log::info('Registering driver - validation passed', $validatedData);
        } catch (\Exception $e) {
            \Log::error('Registering driver - validation failed', ['error' => $e->getMessage(), 'input' => $input]);
            throw $e;
        }

        $profileImagePath = null;
        if ($request->hasFile('profileImage')) {
            try {
                $profileImagePath = $request->file('profileImage')->store('profile_images', 'public');
                \Log::info('Registering driver - profile image stored', ['path' => $profileImagePath]);
            } catch (\Exception $e) {
                \Log::error('Registering driver - profile image store failed', ['error' => $e->getMessage()]);
                throw $e;
            }
        }

        try {
            $driver = Driver::create([
                'name' => $validatedData['name'],
                'surName' => $validatedData['surName'],
                'phone' => $validatedData['phone'],
                'email' => $validatedData['email'],
                'address' => $validatedData['address'],
                'bloodGroup' => $validatedData['bloodGroup'],
                'nationalId' => $validatedData['nationalId'],
                'nationality' => $validated['nationality'] ?? 'Not Specified',
                'profileImage' => $profileImagePath,
            ]);
            \Log::info('Registering driver - driver created', ['driver' => $driver]);
        } catch (\Exception $e) {
            \Log::error('Registering driver - driver creation failed', ['error' => $e->getMessage(), 'data' => $validatedData]);
            throw $e;
        }

        if(!$driver) {
            \Log::error('Registering driver - driver creation returned null', ['validatedData' => $validatedData]);
            return response()->json(['message' => 'Driver registration failed'], 500);
        }

        try {
            $license = License::create([
                'driverId' => $driver->id,
                'licenseNumber' => $validatedData['licenseNumber'],
                'issueDate' => $validatedData['issueDate'],
                'expiryDate' => $validatedData['expiryDate'],
                'plateNumber' => $validatedData['plateNumber'],
                'allowedCategories' => $validatedData['allowedCategories'],
                'dateLieuDelivrance' => $validatedData['dateLieuDelivrance'],
            ]);
            \Log::info('Registering driver - license created', ['license' => $license]);
        } catch (\Exception $e) {
            \Log::error('Registering driver - license creation failed', ['error' => $e->getMessage(), 'driver_id' => $driver->id, 'data' => $validatedData]);
            throw $e;
        }

        if(!$license) {
            \Log::error('Registering driver - license creation returned null', ['driver_id' => $driver->id, 'validatedData' => $validatedData]);
            return response()->json(['message' => 'License registration failed'], 500);
        }

        $cardData = [
            'license_id' => $license->id,
            'cardNumber' => $validatedData['nfcTag'] ?? ('CARD-' . strtoupper(uniqid())),
            'secret' => $request->input('secret'),
            'programmedDate' => now()->toDateString(),
        ];
        try {
            $card = Card::create($cardData);
            \Log::info('Registering driver - card created', ['card' => $card]);
        } catch (\Exception $e) {
            \Log::error('Registering driver - card creation failed', ['error' => $e->getMessage(), 'cardData' => $cardData]);
            throw $e;
        }

        if(!$card) {
            \Log::error('Registering driver - card creation returned null', ['license_id' => $license->id, 'cardData' => $cardData]);
            return response()->json(['message' => 'Card creation failed'], 500);
        }

        \Log::info('Registering driver - all steps successful', [
            'driver' => $driver,
            'license' => $license,
            'card' => $card,
        ]);

        return response()->json([
            'message' => 'Driver, License, and Card registered successfully',
            'driver' => $driver,
            'license' => $license,
            'card' => $card,
        ], 201);
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

    public function printCard(Request $request)
    {
        \Log::info('Printing card', ['request' => $request->all()]);

        $query = $request->input('query');
        if (is_null($query) || trim($query) === '') {
            \Log::info('printCard: Empty query received, returning empty drivers array');
            return response()->json(['drivers' => []]);
        }
        // Try to find by card number first
        $card = \App\Models\Card::with(['license', 'license.driver'])
            ->where('cardNumber', $query)
            ->first();
        if ($card) {
            $license = $card->license;
            $driver = $license ? $license->driver : null;
            \Log::info('printCard: Found by cardNumber', ['cardNumber' => $card->cardNumber, 'driverId' => $driver?->id]);
            $result = [[
                'driver' => $driver,
                'license' => $license,
                'card' => $card,
                'dateLieuDelivrance' => $license?->dateLieuDelivrance,
                'allowedCategories' => $license?->allowedCategories,
            ]];
            return response()->json(['drivers' => $result]);
        }
        // Try to find by license number
        $license = \App\Models\License::with(['driver', 'card'])
            ->where('licenseNumber', $query)
            ->first();
        if ($license && $license->card) {
            $driver = $license->driver;
            $card = $license->card;
            \Log::info('printCard: Found by licenseNumber', ['licenseNumber' => $license->licenseNumber, 'driverId' => $driver?->id]);
            $result = [[
                'driver' => $driver,
                'license' => $license,
                'card' => $card,
                'dateLieuDelivrance' => $license->dateLieuDelivrance,
                'allowedCategories' => $license->allowedCategories,
            ]];
            return response()->json(['drivers' => $result]);
        }
        \Log::info('printCard: No card or license found for query', ['query' => $query]);
        return response()->json(['drivers' => []]);
    }


    /**
     * Store QR code for a card after frontend generates it.
     */
    public function saveCardQr(Request $request)
    {
        $request->validate([
            'cardNumber' => 'required|string|exists:cards,cardNumber',
            'qrCode' => 'required|string', // base64 or SVG
        ]);
        $card = Card::where('cardNumber', $request->cardNumber)->first();
        if (!$card) {
            return response()->json(['error' => 'Card not found'], 404);
        }
        $qrPath = 'cards/' . $card->cardNumber . '_qr.txt';
        \Storage::disk('public')->put($qrPath, $request->qrCode);
        return response()->json(['message' => 'QR code saved', 'cardNumber' => $card->cardNumber]);
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
        \Log::info('Searching by card', ['cardNumber' => $cardNumber]);
        $card = Card::where('cardNumber', $cardNumber)->first();
        if (!$card) {
            \Log::warning('Card not found', ['cardNumber' => $cardNumber]);
            return response()->json(['error' => 'Card not found'], 404);
        }
        \Log::info('Card found', ['card' => $card]);
        $license = $card->license;
        if (!$license) {
            \Log::warning('License not found for card', ['card' => $card]);
            return response()->json(['error' => 'License not found'], 404);
        }
        \Log::info('License found for card', ['license' => $license]);
        $driver = $license->driver()->with(['penalties.penalty'])->first();
        if (!$driver) {
            \Log::warning('Driver not found for license', ['license' => $license]);
            return response()->json(['error' => 'Driver not found'], 404);
        }
        $penalties = $driver->penalties->map(function($pd) {
            return [
                'id' => $pd->id,
                'penaltyType' => $pd->penalty->penaltyType ?? null,
                'amount' => $pd->amount,
                'dateIssued' => $pd->dateIssued,
                'isPaid' => $pd->isPaid,
            ];
        });
        \Log::info('Driver found by card', ['driver' => $driver]);
        // Always return a drivers array, even for single result
        return response()->json([
            'drivers' => [[
                'driver' => [
                    'id' => $driver->id,
                    'name' => $driver->name,
                    'surName' => $driver->surName,
                    'phone' => $driver->phone,
                    'email' => $driver->email,
                    'address' => $driver->address,
                    'bloodGroup' => $driver->bloodGroup,
                    'profileImage' => $driver->profileImage,
                    'nationalId' => $driver->nationalId,
                    'created_at' => $driver->created_at,
                    'updated_at' => $driver->updated_at,
                    'license' => [
                        'id' => $license->id,
                        'driverId' => $license->driverId,
                        'licenseNumber' => $license->licenseNumber,
                        'issueDate' => $license->issueDate,
                        'expiryDate' => $license->expiryDate,
                        'plateNumber' => $license->plateNumber,
                        'dateLieuDelivrance' => $license->dateLieuDelivrance ?? null,
                        'licensesAllowed' => $license->licensesAllowed ?? null,
                        'allowedCategories' => $license->allowedCategories ?? null,
                        'created_at' => $license->created_at,
                        'updated_at' => $license->updated_at,
                        'card' => $license->card ?? null,
                    ],
                    'penalties' => $penalties,
                ],
                'license' => [
                    'id' => $license->id,
                    'driverId' => $license->driverId,
                    'licenseNumber' => $license->licenseNumber,
                    'issueDate' => $license->issueDate,
                    'expiryDate' => $license->expiryDate,
                    'plateNumber' => $license->plateNumber,
                    'dateLieuDelivrance' => $license->dateLieuDelivrance ?? null,
                    'licensesAllowed' => $license->licensesAllowed ?? null,
                    'allowedCategories' => $license->allowedCategories ?? null,
                    'created_at' => $license->created_at,
                    'updated_at' => $license->updated_at,
                    'card' => $license->card ?? null,
                ],
                'card' => $license->card ?? null,
                'penalties' => $penalties,
            ]],
        ]);
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

    public function getAllDrivers(Request $request)
    {
        $drivers = Driver::with('license')->get()->map(function($driver) {
            $license = $driver->license;
            return $this->formatDriverResponse($driver, $license);
        });
        return response()->json(['drivers' => $drivers]);
    }
}
