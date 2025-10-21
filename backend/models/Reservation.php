<?php
class Reservation {
    private $conn;
    private $table = "reservations";

    public $id;
    public $user_name;
    public $email;
    public $session_type;
    public $session_date;
    public $session_time;
    public $notes;
    public $reserved_at;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                 SET user_name=:user_name, email=:email, session_type=:session_type, 
                     session_date=:session_date, session_time=:session_time, 
                     notes=:notes, status='pending'";

        $stmt = $this->conn->prepare($query);

        // Sanitize data
        $this->user_name = Validation::sanitizeInput($this->user_name);
        $this->email = Validation::sanitizeInput($this->email);
        $this->notes = Validation::sanitizeInput($this->notes);

        // Bind parameters
        $stmt->bindParam(":user_name", $this->user_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":session_type", $this->session_type);
        $stmt->bindParam(":session_date", $this->session_date);
        $stmt->bindParam(":session_time", $this->session_time);
        $stmt->bindParam(":notes", $this->notes);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getAvailableSlots($session_type, $session_date) {
        $query = "SELECT session_time FROM " . $this->table . " 
                  WHERE session_type = :session_type 
                  AND session_date = :session_date 
                  AND status != 'cancelled'";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":session_type", $session_type);
        $stmt->bindParam(":session_date", $session_date);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
?>