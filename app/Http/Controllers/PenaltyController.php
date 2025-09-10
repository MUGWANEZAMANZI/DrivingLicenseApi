<?php

namespace App\Http\Controllers;

use App\Models\License;
use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Penalty;
use App\Models\PenaltiesDrivers;

class PenaltyController extends Controller
{
    public function addPenalty(Request $request)
    {
        \Log::info('Received addPenalty request', ['data' => $request->all()]);

        $validator = \Validator::make($request->all(), [
            'plateNumber' => 'required|string|exists:licenses,plateNumber',
            'penalty' => 'required|string',
            'fine' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            \Log::warning('Validation failed for addPenalty', ['errors' => $validator->errors()]);
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();
        \Log::info('Validation passed', ['validated' => $validated]);

        $driver = License::where('plateNumber', $validated['plateNumber'])->first();
        if (!$driver) {
            \Log::warning('Driver not found', ['plateNumber' => $validated['plateNumber']]);
            return response()->json(['message' => 'Driver not found'], 404);
        }

        $penalty = Penalty::firstOrCreate(
            ['penaltyType' => $validated['penalty']],
            ['amount' => $validated['fine']]
        );
        \Log::info('Penalty found or created', ['penalty' => $penalty]);

        try {
            $penaltyDriver = PenaltiesDrivers::create([
                'driver_id' => $driver->id,
                'penalty_id' => $penalty->id,
                'dateIssued' => now()->toDateString(),
                'isPaid' => false,
            ]);
            \Log::info('Penalty attached to driver', ['penalties_drivers' => $penaltyDriver]);
        } catch (\Exception $e) {
            \Log::error('Error saving penalty', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Erreur lors de l\'enregistrement de la pénalité.',
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'Penalty added successfully',
            'driver' => $driver,
            'penalty' => $penalty,
        ], 201);
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
