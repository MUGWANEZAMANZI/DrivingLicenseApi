<?php

return [
    'driver' => [
        'singular' => 'Conducteur',
        'plural' => 'Conducteurs',
        'fields' => [
            'name' => 'Prénom',
            'surName' => 'Nom',
            'phone' => 'Téléphone',
            'email' => 'Email',
            'address' => 'Adresse',
            'bloodGroup' => 'Groupe sanguin',
            'nationalId' => 'Numéro national',
            'profileImage' => 'Photo de profil',
        ],
    ],
    'license' => [
        'singular' => 'Permis',
        'plural' => 'Permis',
        'fields' => [
            'driverId' => 'Conducteur',
            'licenseNumber' => 'Numéro de permis',
            'issueDate' => 'Date de délivrance',
            'expiryDate' => "Date d'expiration",
            'plateNumber' => 'Numéro d’immatriculation',
            'dateLieuDelivrance' => 'Lieu/Date de délivrance',
            'licensesAllowed' => 'Permis autorisés',
            'allowedCategories' => 'Catégories autorisées',
        ],
    ],
    'card' => [
        'singular' => 'Carte',
        'plural' => 'Cartes',
        'fields' => [
            'license_id' => 'Permis',
            'cardNumber' => 'Numéro de carte',
            'secret' => 'Secret',
            'programmedDate' => 'Date programmée',
        ],
    ],
    'penalty' => [
        'singular' => 'Infraction',
        'plural' => 'Infractions',
        'fields' => [
            'penaltyType' => "Type d'infraction",
            'amount' => 'Montant',
        ],
    ],
    'penaltiesDrivers' => [
        'singular' => 'Infraction conducteur',
        'plural' => 'Infractions conducteurs',
        'fields' => [
            'driver_id' => 'Conducteur',
            'penalty_id' => 'Infraction',
            'amount' => 'Montant',
            'dateIssued' => 'Date d’émission',
            'isPaid' => 'Payé',
        ],
    ],
    'user' => [
        'singular' => 'Utilisateur',
        'plural' => 'Utilisateurs',
        'fields' => [
            'name' => 'Nom',
            'email' => 'Email',
            'password' => 'Mot de passe',
        ],
    ],
];


