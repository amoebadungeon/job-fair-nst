<?php
include_once 'backend/config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    
    if ($db) {
        echo "✅ Database connection successful!";
    } else {
        echo "❌ Database connection failed";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>