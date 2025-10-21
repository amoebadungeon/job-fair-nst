<?php
class Contact {
    private $conn;
    private $table = "contacts";

    public $id;
    public $name;
    public $email;
    public $phone;
    public $subject;
    public $message;
    public $submitted_at;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                 SET name=:name, email=:email, phone=:phone, 
                     subject=:subject, message=:message, status='new'";

        $stmt = $this->conn->prepare($query);

        // Sanitize data
        $this->name = Validation::sanitizeInput($this->name);
        $this->email = Validation::sanitizeInput($this->email);
        $this->phone = Validation::sanitizeInput($this->phone);
        $this->subject = Validation::sanitizeInput($this->subject);
        $this->message = Validation::sanitizeInput($this->message);

        // Bind parameters
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":subject", $this->subject);
        $stmt->bindParam(":message", $this->message);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>