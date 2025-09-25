<?php
require_once 'config.php';

$sessionId   = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text        = $_POST["text"];

$response = "";

$textArray = explode('*', $text);
$level = count($textArray);

session_start();
$sessionKey = 'ussd_' . $sessionId;

try {
    if ($text == "") {
        $response = buildMainMenu();
    } else if ($text == "1") {
        $response = "CON Enter your email address:\n";
        $response .= "0. Back to main menu";
    } else if ($text == "2") {
        $response = "CON Enter your email address:\n";
        $response .= "0. Back to main menu";
    } else if ($text == "3") {
        $response = "CON Enter your email address:\n";
        $response .= "0. Back to main menu";
    } else if ($text == "4") {
        $response = getHealthFacilities();
    } else if ($text == "0") {
        $response = EXIT_MESSAGE;
    } else if (preg_match('/^1\*[a-zA-Z0-9@._-]+$/', $text)) {
        $userEmail = trim($textArray[1]);
        $response = "CON Enter your password:\n";
        $response .= "0. Back to main menu";
    } else if (preg_match('/^2\*[a-zA-Z0-9@._-]+$/', $text)) {
        $userEmail = trim($textArray[1]);
        $response = "CON Enter your password:\n";
        $response .= "0. Back to main menu";
    } else if (preg_match('/^3\*[a-zA-Z0-9@._-]+$/', $text)) {
        $userEmail = trim($textArray[1]);
        $response = "CON Enter your password:\n";
        $response .= "0. Back to main menu";
    } else if (preg_match('/^1\*[a-zA-Z0-9@._-]+\*[a-zA-Z0-9@._-]+$/', $text)) {
        $userEmail = trim($textArray[1]);
        $userPassword = trim($textArray[2]);
        $response = checkImmunizationStatus($userEmail, $userPassword, $phoneNumber);
    } else if (preg_match('/^2\*[a-zA-Z0-9@._-]+\*[a-zA-Z0-9@._-]+$/', $text)) {
        $userEmail = trim($textArray[1]);
        $userPassword = trim($textArray[2]);
        $response = listChildren($userEmail, $userPassword, $phoneNumber);
    } else if (preg_match('/^3\*[a-zA-Z0-9@._-]+\*[a-zA-Z0-9@._-]+$/', $text)) {
        $userEmail = trim($textArray[1]);
        $userPassword = trim($textArray[2]);
        $response = getVaccinationHistory($userEmail, $userPassword, $phoneNumber);
    } else {
        $response = INVALID_INPUT . "\n";
        $response .= "0. Back to main menu";
    }
} catch (Exception $e) {
    $response = API_ERROR;
    error_log("USSD Error: " . $e->getMessage());
}

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
function authenticateUser($email, $password)
{
    $loginData = [
        'email' => $email,
        'password' => $password
    ];

    $response = makeApiCall('POST', '/login', $loginData);

    if ($response && isset($response['token'])) {
        return $response['token'];
    }

    return null;
}

/**
 * Check immunization status
 */
function checkImmunizationStatus($userEmail, $userPassword, $sessionPhone)
{
    $token = authenticateUser($userEmail, $userPassword);

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
        $response .= "Next Appointment: " . $nextAppointment . "\n";

        // Get completed vaccines for this child
        $vaccinationHistory = makeApiCall('GET', '/appointments/baby/vaccination-history/' . $child['id'], null, $token);

        if ($vaccinationHistory && isset($vaccinationHistory['data']['by_status']['Completed']['appointments'])) {
            $completedVaccines = $vaccinationHistory['data']['by_status']['Completed']['appointments'];

            if (!empty($completedVaccines)) {
                $response .= "Done: ";
                $vaccineNames = [];
                foreach ($completedVaccines as $appointment) {
                    if (isset($appointment['vaccine']['vaccine_name'])) {
                        $vaccineNames[] = $appointment['vaccine']['vaccine_name'];
                    }
                }
                $response .= implode(', ', $vaccineNames) . "\n";
            } else {
                $response .= "Done: None\n";
            }
        } else {
            $response .= "Done: None\n";
        }

        $response .= "\n";
    }

    $response .= "";
    return $response;
}

/**
 * List user's children
 */
function listChildren($userEmail, $userPassword, $sessionPhone)
{
    $token = authenticateUser($userEmail, $userPassword);

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

    $response .= "";
    return $response;
}

/**
 * Get vaccination history
 */
function getVaccinationHistory($userEmail, $userPassword, $sessionPhone)
{
    $token = authenticateUser($userEmail, $userPassword);

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

    $response .= "";
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

    $response .= "";
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
        $response = trim($response);
        if (strpos($response, '+') === 0) {
            $response = substr($response, 1);
        }
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
    $phone = preg_replace('/[^0-9+]/', '', $phone);

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
 * Log USSD session for debugging.
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
