<?php
// USSD Configuration File

// API Configuration
define('API_BASE_URL', 'https://5ac740d9c418.ngrok-free.app/api'); // Update this to your Laravel API URL
define('API_TIMEOUT', 30); // API request timeout in seconds

// USSD Configuration
define('MAX_MENU_LEVELS', 5);
define('SESSION_TIMEOUT', 300); // 5 minutes

// Error Messages
define('AUTH_ERROR', 'END Authentication failed. Please check your credentials.');
define('API_ERROR', 'END Service temporarily unavailable. Please try again later.');
define('INVALID_INPUT', 'CON Invalid selection. Please try again:');

// Success Messages
define('WELCOME_MESSAGE', 'CON Karibu to Immunization System');
define('EXIT_MESSAGE', 'END Thank you for using Immunization System. Goodbye!');

// Menu Options
$MENU_OPTIONS = [
    'main' => [
        '1' => 'Check immunization status',
        '2' => 'List my children',
        '3' => 'View vaccination history',
        '4' => 'Schedule appointment',
        '5' => 'Health facilities',
        '0' => 'Exit'
    ],
    'auth' => [
        '0' => 'Back to main menu'
    ]
];

// Health Facilities Data
$HEALTH_FACILITIES = [
    [
        'name' => 'Central Hospital',
        'location' => 'Nairobi CBD',
        'phone' => '+254-20-123-4567',
        'services' => 'Full immunization services'
    ],
    [
        'name' => 'County Hospital',
        'location' => 'Mombasa',
        'phone' => '+254-41-123-4567',
        'services' => 'Full immunization services'
    ],
];
