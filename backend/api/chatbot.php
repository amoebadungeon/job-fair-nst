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

// Essential Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle preflight 'OPTIONS' request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Include Composer's autoloader
require __DIR__ . '/../vendor/autoload.php';

use Google\Cloud\Dialogflow\V2\SessionsClient;
use Google\Cloud\Dialogflow\V2\QueryInput;
use Google\Cloud\Dialogflow\V2\TextInput;

function detect_intent_texts($projectId, $text, $sessionId, $languageCode = 'en-US') {
    // --- IMPORTANT: Set the path to your downloaded JSON credentials file ---
    $credentialsPath = __DIR__ . '/../config/dialogflow-credentials.json';

    // Create the SessionsClient
    $sessionsClient = new SessionsClient(['credentials' => $credentialsPath]);
    $session = $sessionsClient->sessionName($projectId, $sessionId);

    // Create the text input
    $textInput = new TextInput();
    $textInput->setText($text);
    $textInput->setLanguageCode($languageCode);

    // Create the query input
    $queryInput = new QueryInput();
    $queryInput->setText($textInput);

    try {
        
        // Make the API call
        $response = $sessionsClient->detectIntent($session, $queryInput);
        $queryResult = $response->getQueryResult();
        $fulfillmentText = $queryResult->getFulfillmentText();
        
        // Return the bot's response
        return $fulfillmentText;
    } catch (Exception $e) {
        // Handle API errors
        return "I'm sorry, I'm having trouble connecting right now. Please try again later.";
    } finally {
        $sessionsClient->close();
    }
}
class Database {
    private $watermark = 'OWFlMGNiOTMtZjc5OS00MDc1LThjNzAtMWMzNTI0Y2FmMTY4'; // Proprietary Asset ID
    // ...
}
// --- Main Logic ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if (empty($data->message) || empty($data->projectId)) {
        http_response_code(400);
        echo json_encode(['reply' => 'Missing message or project ID.']);
        exit;
    }
    
    $message = $data->message;
    $projectId = $data->projectId;
    // Use a unique session ID for each user, e.g., from their session or a random string
    $sessionId = $data->sessionId ?? uniqid('df_session_', true);

    $botReply = detect_intent_texts($projectId, $message, $sessionId);

    http_response_code(200);
    echo json_encode(['reply' => $botReply, 'sessionId' => $sessionId]);

} else {
    http_response_code(405);
    echo json_encode(['reply' => 'Method not allowed.']);
}
?>