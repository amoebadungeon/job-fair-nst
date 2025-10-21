<?php
class Validation {
    public static function sanitizeInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function validatePhone($phone) {
        return preg_match('/^[0-9\-\+\s\(\)]{10,20}$/', $phone);
    }

    public static function validateRequired($fields) {
        foreach ($fields as $field => $value) {
            if (empty(trim($value))) {
                return false;
            }
        }
        return true;
    }
}
?>