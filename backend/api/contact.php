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

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/Contact.php';
include_once '../utils/Validation.php';

$database = new Database();
$db = $database->getConnection();
$contact = new Contact($db);

$data = json_decode(file_get_contents("php://input"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate required fields
    $required_fields = [
        'name' => $data->name ?? '',
        'email' => $data->email ?? '',
        'message' => $data->message ?? ''
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

    // Set contact data
    $contact->name = $data->name;
    $contact->email = $data->email;
    $contact->phone = $data->phone ?? '';
    $contact->subject = $data->subject ?? '';
    $contact->message = $data->message;

    if ($contact->create()) {
        http_response_code(201);
        echo json_encode(["message" => "Contact form submitted successfully."]);
    } else {
        http_response_code(503);
        echo json_encode(["message" => "Unable to submit contact form."]);
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "Method not allowed."]);
}
?>