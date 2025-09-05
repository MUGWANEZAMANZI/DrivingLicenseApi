<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Penalty;
use App\Models\PenaltiesDrivers;

class PenaltyController extends Controller
{
    public function addPenalty(Request $request)
    {
        $validated = $request->validate([
            'nationalId' => 'required|string|exists:drivers,nationalId',
            'penalty' => 'required|string',
            'fine' => 'required|integer',
        ]);

        $driver = Driver::where('nationalId', $validated['nationalId'])->first();
        if (!$driver) {
            return response()->json(['message' => 'Driver not found'], 404);
        }

        // Find or create penalty type
        $penalty = Penalty::firstOrCreate(
            ['penaltyType' => $validated['penalty']],
            ['amount' => $validated['fine']]
        );

        // Attach penalty to driver
        try {
            PenaltiesDrivers::create([
                'driver_id' => $driver->id,
                'penalty_id' => $penalty->id,
                'amount' => $validated['fine'],
                'dateIssued' => now()->toDateString(),
                'isPaid' => false,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de l\'enregistrement de la pénalité.', 'error' => $e->getMessage()], 500);
        }
        return response()->json(['message' => 'Pénalité enregistrée.']);
    }

    // Get all penalties for a license number
    public function getPenaltiesByLicense($licenseNumber)
    {
        $license = \App\Models\License::where('licenseNumber', $licenseNumber)->first();
        if (!$license) {
            return response()->json(['message' => 'License not found'], 404);
        }
        $driver = $license->driver;
        if (!$driver) {
            return response()->json(['message' => 'Driver not found'], 404);
        }
        $penalties = PenaltiesDrivers::with('penalty')
            ->where('driver_id', $driver->id)
            ->orderByDesc('dateIssued')
            ->get()
            ->map(function($pd) {
                return [
                    'penaltyType' => $pd->penalty ? $pd->penalty->penaltyType : null,
                    'amount' => $pd->amount,
                    'dateIssued' => $pd->dateIssued,
                    'isPaid' => $pd->isPaid,
                ];
            });
        return response()->json(['penalties' => $penalties]);
    }
}

