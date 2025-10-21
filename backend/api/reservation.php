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
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/Reservation.php';
include_once '../utils/Validation.php';

$database = new Database();
$db = $database->getConnection();
$reservation = new Reservation($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    // Validate required fields
    $required_fields = [
        'user_name' => $data->user_name ?? '',
        'email' => $data->email ?? '',
        'session_type' => $data->session_type ?? '',
        'session_date' => $data->session_date ?? '',
        'session_time' => $data->session_time ?? ''
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

    // Check if slot is available
    $booked_slots = $reservation->getAvailableSlots($data->session_type, $data->session_date);
    if (in_array($data->session_time, $booked_slots)) {
        http_response_code(400);
        echo json_encode(["message" => "Selected time slot is no longer available."]);
        exit;
    }

    // Set reservation data
    $reservation->user_name = $data->user_name;
    $reservation->email = $data->email;
    $reservation->session_type = $data->session_type;
    $reservation->session_date = $data->session_date;
    $reservation->session_time = $data->session_time;
    $reservation->notes = $data->notes ?? '';

    if ($reservation->create()) {
        http_response_code(201);
        echo json_encode(["message" => "Reservation submitted successfully."]);
    } else {
        http_response_code(503);
        echo json_encode(["message" => "Unable to submit reservation."]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Get available slots for a specific date and session type
    $session_type = $_GET['session_type'] ?? '';
    $session_date = $_GET['session_date'] ?? '';

    if (empty($session_type) || empty($session_date)) {
        http_response_code(400);
        echo json_encode(["message" => "Session type and date are required."]);
        exit;
    }

    $booked_slots = $reservation->getAvailableSlots($session_type, $session_date);
    
    // Define all available time slots
    $all_slots = [
        '09:00:00', '10:00:00', '11:00:00', '12:00:00',
        '13:00:00', '14:00:00', '15:00:00', '16:00:00'
    ];

    $available_slots = array_diff($all_slots, $booked_slots);
    
    echo json_encode([
        "available_slots" => array_values($available_slots),
        "booked_slots" => $booked_slots
    ]);
} else {
    http_response_code(405);
    echo json_encode(["message" => "Method not allowed."]);
}
?>