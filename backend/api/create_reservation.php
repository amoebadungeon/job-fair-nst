<?php
/**
 * Copyright (c) 2025 [Mustaqeem Sopee]
 *
 * This software is proprietary and confidential. Unauthorized copying,
 * sharing, or commercial use of this file, via any medium, is strictly prohibited.
 *
 * @author   Mustaqeem Sopee <johnxblend001@gmail.com>
 * @copyright 2025 Mustaqeem Sopee
 */

// --- Essential Headers for CORS and JSON Response ---
header("Access-Control-Allow-Origin: *"); // Allows any origin to access the API. For production, you might want to restrict this.
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle preflight 'OPTIONS' request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
http_response_code(200);
exit;
}

// --- Include Database and Model Files ---
include_once '../config/database.php'; // Assumes your DB connection logic is here
include_once '../models/Reservation.php'; // Assumes your Reservation model is here

// --- Validation (Simple Example) ---
function validateEmail($email) {
return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// --- Main Logic ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
// Get the posted JSON data
$data = json_decode(file_get_contents("php://input"));

// Basic validation
if (
empty($data->user_name) ||
empty($data->email) ||
empty($data->session_type) ||
empty($data->session_date) ||
empty($data->session_time)
) {
http_response_code(400); // Bad Request
echo json_encode(["message" => "Incomplete data. Please fill all required fields."]);
exit;
}

if (!validateEmail($data->email)) {
http_response_code(400); // Bad Request
echo json_encode(["message" => "Invalid email format."]);
exit;
}

// --- Database Interaction ---
$database = new Database();
$db = $database->getConnection();

$reservation = new Reservation($db);

// Assign data to reservation object
$reservation->user_name = $data->user_name;
$reservation->email = $data->email;
$reservation->session_type = $data->session_type;
$reservation->session_date = $data->session_date;
$reservation->session_time = $data->session_time;
$reservation->notes = $data->notes ?? ''; // Optional notes field

// Attempt to create the reservation
if ($reservation->create()) {
http_response_code(201); // Created
echo json_encode(["message" => "Reservation submitted successfully."]);
} else {
http_response_code(503); // Service Unavailable
echo json_encode(["message" => "Unable to submit reservation. Please try again later."]);
}

} else {
http_response_code(405); // Method Not Allowed
echo json_encode(["message" => "Method not allowed."]);
}
?>