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

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");

// Allow common headers that might be sent with an API request.
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Allow specific HTTP methods. OPTIONS is crucial for preflight requests.
header("Access-Control-Allow-Methods: POST, OPTIONS");

// Set the response content type to JSON.
header("Content-Type: application/json; charset=UTF-8");

// The browser will send an OPTIONS request first to check permissions.
// We need to respond with a 200 OK status and exit immediately.
// We don't need to process any data for an OPTIONS request.
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}
// =========================================================================
// === END OF FIX ==========================================================
// =========================================================================


include_once '../config/database.php';
include_once '../models/Exhibitor.php';
include_once '../utils/Validation.php';

// This check is now redundant because we already handled OPTIONS above,
// but it's good practice to keep it to ensure only POST proceeds.
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    echo json_encode(["message" => "Method not allowed."]);
    exit;
}

$database = new Database();
$db = $database->getConnection();
$exhibitor = new Exhibitor($db);

$data = json_decode(file_get_contents("php://input"));

// It's safer to check if $data is null, in case of invalid JSON
if (is_null($data)) {
    http_response_code(400);
    echo json_encode(["message" => "Invalid JSON data."]);
    exit;
}

// Validate required fields
$required_fields = [
    'company_name' => $data->company_name ?? '',
    'contact_person' => $data->contact_person ?? '',
    'email' => $data->email ?? '',
    'phone' => $data->phone ?? ''
];

if (!Validation::validateRequired($required_fields)) {
    http_response_code(400);
    echo json_encode(["message" => "All required fields must be filled."]);
    exit;
}

if (!Validation::validateEmail($data->email)) {
    http_response_code(400);
    echo json_encode(["message" => "Invalid email format."]);
    exit;
}

if (!Validation::validatePhone($data->phone)) {
    http_response_code(400);
    echo json_encode(["message" => "Invalid phone number format."]);
    exit;
}

// Set exhibitor data
$exhibitor->company_name = $data->company_name;
$exhibitor->contact_person = $data->contact_person;
$exhibitor->email = $data->email;
$exhibitor->phone = $data->phone;
$exhibitor->industry = $data->industry ?? '';
$exhibitor->company_size = $data->company_size ?? '';
$exhibitor->requirements = $data->requirements ?? '';
$exhibitor->booth_preference = $data->booth_preference ?? 'standard';

if ($exhibitor->create()) {
    http_response_code(201);
    echo json_encode(["message" => "Exhibitor registration submitted successfully."]);
} else {
    http_response_code(503);
    echo json_encode(["message" => "Unable to submit exhibitor registration."]);
}
?>