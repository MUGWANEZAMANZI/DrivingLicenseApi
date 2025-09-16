<?php

return [
    'driver' => [
        'singular' => 'Driver',
        'plural' => 'Drivers',
        'fields' => [
            'name' => 'Name',
            'surName' => 'Surname',
            'phone' => 'Phone',
            'email' => 'Email',
            'address' => 'Address',
            'bloodGroup' => 'Blood Group',
            'nationalId' => 'National ID',
            'profileImage' => 'Profile Image',
        ],
    ],
    'license' => [
        'singular' => 'License',
        'plural' => 'Licenses',
        'fields' => [
            'driverId' => 'Driver',
            'licenseNumber' => 'License Number',
            'issueDate' => 'Issue Date',
            'expiryDate' => 'Expiry Date',
            'plateNumber' => 'Plate Number',
            'dateLieuDelivrance' => 'Place/Date of Issue',
            'licensesAllowed' => 'Licenses Allowed',
            'allowedCategories' => 'Allowed Categories',
        ],
    ],
    'card' => [
        'singular' => 'Card',
        'plural' => 'Cards',
        'fields' => [
            'license_id' => 'License',
            'cardNumber' => 'Card Number',
            'secret' => 'Secret',
            'programmedDate' => 'Programmed Date',
        ],
    ],
    'penalty' => [
        'singular' => 'Penalty',
        'plural' => 'Penalties',
        'fields' => [
            'penaltyType' => 'Penalty Type',
            'amount' => 'Amount',
        ],
    ],
    'penaltiesDrivers' => [
        'singular' => 'Driver Penalty',
        'plural' => 'Drivers Penalties',
        'fields' => [
            'driver_id' => 'Driver',
            'penalty_id' => 'Penalty',
            'amount' => 'Amount',
            'dateIssued' => 'Date Issued',
            'isPaid' => 'Paid',
        ],
    ],
    'user' => [
        'singular' => 'User',
        'plural' => 'Users',
        'fields' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ],
    ],
];


