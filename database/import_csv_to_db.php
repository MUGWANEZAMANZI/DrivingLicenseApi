<?php

/**
 * DAY 3: CSV to Database Import Script
 * 
 * This script reads a CSV file (from Day 2) and inserts the data into the users table.
 * Usage: php database/import_csv_to_db.php
 */

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Bootstrap Laravel application
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Configuration
$csvFile = __DIR__ . '/users.csv';

if (!file_exists($csvFile)) {
    echo "Error: CSV file not found at {$csvFile}\n";
    echo "Please ensure you have a users.csv file from Day 2 in the database directory.\n";
    exit(1);
}

echo "Starting CSV import...\n";
echo "Reading from: {$csvFile}\n\n";

// Open CSV file
$handle = fopen($csvFile, 'r');
if ($handle === false) {
    echo "Error: Could not open CSV file.\n";
    exit(1);
}

// Read header row
$headers = fgetcsv($handle);
if ($headers === false) {
    echo "Error: Could not read CSV headers.\n";
    fclose($handle);
    exit(1);
}

echo "CSV Headers: " . implode(', ', $headers) . "\n\n";

$insertedCount = 0;
$errorCount = 0;
$rowNumber = 1;

// Process each row
while (($row = fgetcsv($handle)) !== false) {
    $rowNumber++;
    
    try {
        // Map CSV columns to database columns
        $data = array_combine($headers, $row);
        
        // Prepare user data
        $userData = [
            'name' => $data['name'] ?? 'Unknown',
            'email' => $data['email'] ?? "user{$rowNumber}@example.com",
            'password' => Hash::make($data['password'] ?? 'password'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
        // Check if email already exists
        $existingUser = DB::table('users')->where('email', $userData['email'])->first();
        
        if ($existingUser) {
            echo "Row {$rowNumber}: Skipped - Email '{$userData['email']}' already exists\n";
            continue;
        }
        
        // Insert into database
        DB::table('users')->insert($userData);
        $insertedCount++;
        echo "Row {$rowNumber}: Inserted user '{$userData['name']}' with email '{$userData['email']}'\n";
        
    } catch (Exception $e) {
        $errorCount++;
        echo "Row {$rowNumber}: Error - {$e->getMessage()}\n";
    }
}

fclose($handle);

echo "\n=================================\n";
echo "Import completed!\n";
echo "Total rows processed: " . ($rowNumber - 1) . "\n";
echo "Successfully inserted: {$insertedCount}\n";
echo "Errors: {$errorCount}\n";
echo "=================================\n";
