<?php
// Advanced USSD Immunization Management System
// Enhanced version with better error handling and session management

require_once 'config.php';

// Read the variables sent via POST from our USSD gateway
$sessionId   = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text        = $_POST["text"];

// Initialize response
$response = "";

// Parse the text input to determine menu level and selection
$textArray = explode('*', $text);
$level = count($textArray);

// Start session management
session_start();
$sessionKey = 'ussd_' . $sessionId;

try {
    if ($text == "") {
        // Main menu - first request
        $response = buildMainMenu();
    } else if ($text == "1") {
        // Check immunization status - request credentials
        $response = "CON Enter your phone number or National ID:\n";
        $response .= "0. Back to main menu";
    } else if ($text == "2") {
        // List children - request credentials
        $response = "CON Enter your phone number or National ID:\n";
        $response .= "0. Back to main menu";
    } else if ($text == "3") {
        // View vaccination history - request credentials
        $response = "CON Enter your phone number or National ID:\n";
        $response .= "0. Back to main menu";
    } else if ($text == "4") {
        // Schedule appointment - request credentials
        $response = "CON Enter your phone number or National ID:\n";
        $response .= "0. Back to main menu";
    } else if ($text == "5") {
        // Health facilities
        $response = getHealthFacilities();
    } else if ($text == "0") {
        // Exit
        $response = EXIT_MESSAGE;
    } else if (preg_match('/^1\*[0-9+\s]+$/', $text)) {
        // User entered phone/ID for immunization status check
        $userInput = trim($textArray[1]);
        $response = checkImmunizationStatus($userInput, $phoneNumber);
    } else if (preg_match('/^2\*[0-9+\s]+$/', $text)) {
        // User entered phone/ID for listing children
        $userInput = trim($textArray[1]);
        $response = listChildren($userInput, $phoneNumber);
    } else if (preg_match('/^3\*[0-9+\s]+$/', $text)) {
        // User entered phone/ID for vaccination history
        $userInput = trim($textArray[1]);
        $response = getVaccinationHistory($userInput, $phoneNumber);
    } else if (preg_match('/^4\*[0-9+\s]+$/', $text)) {
        // User entered phone/ID for appointment scheduling
        $userInput = trim($textArray[1]);
        $response = scheduleAppointment($userInput, $phoneNumber);
    } else {
        // Invalid input
        $response = INVALID_INPUT . "\n";
        $response .= "0. Back to main menu";
    }
} catch (Exception $e) {
    $response = API_ERROR;
    error_log("USSD Error: " . $e->getMessage());
}

// Echo the response back to the USSD gateway
header('Content-type: text/plain');
echo $response;

/**
 * Build main menu
 */
function buildMainMenu()
{
    global $MENU_OPTIONS;

    $response = WELCOME_MESSAGE . "\n";
    foreach ($MENU_OPTIONS['main'] as $key => $value) {
        $response .= $key . ". " . $value . "\n";
    }

    return $response;
}

/**
 * Authenticate user and get API token
 */
function authenticateUser($phoneNumber, $nationalId = null)
{
    $loginData = [
        'phone_number' => cleanPhoneNumber($phoneNumber),
        'password' => $nationalId ?: cleanPhoneNumber($phoneNumber)
    ];

    $response = makeApiCall('POST', '/login', $loginData);

    if ($response && isset($response['token'])) {
        return $response['token'];
    }

    // Try with national ID as phone number
    if ($nationalId) {
        $loginData = [
            'phone_number' => $nationalId,
            'password' => $nationalId
        ];

        $response = makeApiCall('POST', '/login', $loginData);

        if ($response && isset($response['token'])) {
            return $response['token'];
        }
    }

    return null;
}

/**
 * Check immunization status
 */
function checkImmunizationStatus($userInput, $sessionPhone)
{
    $token = authenticateUser($userInput);

    if (!$token) {
        return AUTH_ERROR;
    }

    // Get user's children
    $guardianId = getUserGuardianId($token);
    if (!$guardianId) {
        return "END No guardian account found.";
    }

    $children = makeApiCall('GET', '/guardians/' . $guardianId . '/babies', null, $token);

    if (!$children || empty($children)) {
        return "END No children found for this account.";
    }

    $response = "END Immunization Status:\n\n";

    foreach ($children as $child) {
        $status = $child['immunization_status'] ?? 'Unknown';
        $patientId = $child['patient_id'] ?? 'N/A';
        $nextAppointment = $child['next_appointment_date'] ?? 'Not scheduled';

        $response .= "Child: " . $child['first_name'] . "\n";
        $response .= "Patient ID: " . $patientId . "\n";
        $response .= "Status: " . $status . "\n";
        $response .= "Next Appointment: " . $nextAppointment . "\n\n";
    }

    $response .= "0. Back to main menu";
    return $response;
}

/**
 * List user's children
 */
function listChildren($userInput, $sessionPhone)
{
    $token = authenticateUser($userInput);

    if (!$token) {
        return AUTH_ERROR;
    }

    $guardianId = getUserGuardianId($token);
    if (!$guardianId) {
        return "END No guardian account found.";
    }

    $children = makeApiCall('GET', '/guardians/' . $guardianId . '/babies', null, $token);

    if (!$children || empty($children)) {
        return "END No children found for this account.";
    }

    $response = "END Your Children:\n\n";

    foreach ($children as $index => $child) {
        $patientId = $child['patient_id'] ?? 'N/A';
        $dob = $child['date_of_birth'] ?? 'Unknown';
        $gender = $child['gender'] ?? 'Unknown';
        $status = $child['immunization_status'] ?? 'Unknown';

        $response .= ($index + 1) . ". " . $child['first_name'] . "\n";
        $response .= "   Patient ID: " . $patientId . "\n";
        $response .= "   DOB: " . $dob . "\n";
        $response .= "   Gender: " . $gender . "\n";
        $response .= "   Status: " . $status . "\n\n";
    }

    $response .= "0. Back to main menu";
    return $response;
}

/**
 * Get vaccination history
 */
function getVaccinationHistory($userInput, $sessionPhone)
{
    $token = authenticateUser($userInput);

    if (!$token) {
        return AUTH_ERROR;
    }

    $guardianId = getUserGuardianId($token);
    if (!$guardianId) {
        return "END No guardian account found.";
    }

    $history = makeApiCall('GET', '/appointments/guardian/vaccination-history/' . $guardianId, null, $token);

    if (!$history || !isset($history['data']) || empty($history['data'])) {
        return "END No vaccination history found.";
    }

    $response = "END Vaccination History:\n\n";

    foreach ($history['data'] as $babyData) {
        $response .= "Child: " . $babyData['baby_name'] . "\n";
        $response .= "Total Appointments: " . $babyData['total_appointments'] . "\n";

        foreach ($babyData['by_status'] as $status => $statusData) {
            if ($statusData['count'] > 0) {
                $response .= $status . ": " . $statusData['count'] . " appointments\n";
            }
        }
        $response .= "\n";
    }

    $response .= "0. Back to main menu";
    return $response;
}

/**
 * Schedule appointment (simplified version)
 */
function scheduleAppointment($userInput, $sessionPhone)
{
    $token = authenticateUser($userInput);

    if (!$token) {
        return AUTH_ERROR;
    }

    $guardianId = getUserGuardianId($token);
    if (!$guardianId) {
        return "END No guardian account found.";
    }

    // Get user's children for appointment scheduling
    $children = makeApiCall('GET', '/guardians/' . $guardianId . '/babies', null, $token);

    if (!$children || empty($children)) {
        return "END No children found. Please register a child first.";
    }

    $response = "END To schedule an appointment:\n\n";
    $response .= "Call: +254-20-123-4567\n";
    $response .= "Or visit the nearest health facility\n\n";

    $response .= "Your children:\n";
    foreach ($children as $index => $child) {
        $response .= ($index + 1) . ". " . $child['first_name'] . " (ID: " . $child['patient_id'] . ")\n";
    }

    $response .= "\nAvailable vaccines:\n";

    // Get available vaccines
    $vaccines = makeApiCall('GET', '/vaccines', null, $token);
    if ($vaccines && isset($vaccines['vaccines'])) {
        foreach (array_slice($vaccines['vaccines'], 0, 5) as $vaccine) {
            $response .= "- " . $vaccine['vaccine_name'] . "\n";
        }
    }

    $response .= "\n0. Back to main menu";
    return $response;
}

/**
 * Get health facilities
 */
function getHealthFacilities()
{
    global $HEALTH_FACILITIES;

    $response = "END Health Facilities:\n\n";

    foreach ($HEALTH_FACILITIES as $index => $facility) {
        $response .= ($index + 1) . ". " . $facility['name'] . "\n";
        $response .= "   Location: " . $facility['location'] . "\n";
        $response .= "   Phone: " . $facility['phone'] . "\n";
        $response .= "   Services: " . $facility['services'] . "\n\n";
    }

    $response .= "0. Back to main menu";
    return $response;
}

/**
 * Get user's guardian ID from token
 */
function getUserGuardianId($token)
{
    $user = makeApiCall('GET', '/user', null, $token);

    if ($user && isset($user['id'])) {
        return $user['id'];
    }

    return null;
}

/**
 * Make API call to Laravel backend
 */
function makeApiCall($method, $endpoint, $data = null, $token = null)
{
    $url = API_BASE_URL . $endpoint;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, API_TIMEOUT);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Bearer ' . $token
    ]);

    if ($method === 'POST' && $data) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        error_log("CURL Error: " . $error);
        return null;
    }

    if ($httpCode >= 200 && $httpCode < 300) {
        return json_decode($response, true);
    }

    error_log("API Error: HTTP " . $httpCode . " - " . $response);
    return null;
}

/**
 * Clean phone number format
 */
function cleanPhoneNumber($phone)
{
    // Remove any non-numeric characters except +
    $phone = preg_replace('/[^0-9+]/', '', $phone);

    // Add country code if missing
    if (!str_starts_with($phone, '+')) {
        if (str_starts_with($phone, '0')) {
            $phone = '+254' . substr($phone, 1);
        } elseif (str_starts_with($phone, '254')) {
            $phone = '+' . $phone;
        } else {
            $phone = '+254' . $phone;
        }
    }

    return $phone;
}

/**
 * Log USSD session for debugging
 */
function logUssdSession($sessionId, $phoneNumber, $text, $response)
{
    $logData = [
        'timestamp' => date('Y-m-d H:i:s'),
        'session_id' => $sessionId,
        'phone_number' => $phoneNumber,
        'input' => $text,
        'output' => $response
    ];

    error_log("USSD Session: " . json_encode($logData));
}
