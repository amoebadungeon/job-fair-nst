<?php
class Exhibitor {
    private $conn;
    private $table = "exhibitors";

    public $id;
    public $company_name;
    public $contact_person;
    public $email;
    public $phone;
    public $industry;
    public $company_size;
    public $requirements;
    public $booth_preference;
    public $registered_at;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                 SET company_name=:company_name, contact_person=:contact_person, 
                     email=:email, phone=:phone, industry=:industry, 
                     company_size=:company_size, requirements=:requirements, 
                     booth_preference=:booth_preference, status='pending'";

        $stmt = $this->conn->prepare($query);

        // Sanitize data
        $this->company_name = Validation::sanitizeInput($this->company_name);
        $this->contact_person = Validation::sanitizeInput($this->contact_person);
        $this->email = Validation::sanitizeInput($this->email);
        $this->phone = Validation::sanitizeInput($this->phone);
        $this->industry = Validation::sanitizeInput($this->industry);
        $this->requirements = Validation::sanitizeInput($this->requirements);

        // Bind parameters
        $stmt->bindParam(":company_name", $this->company_name);
        $stmt->bindParam(":contact_person", $this->contact_person);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":industry", $this->industry);
        $stmt->bindParam(":company_size", $this->company_size);
        $stmt->bindParam(":requirements", $this->requirements);
        $stmt->bindParam(":booth_preference", $this->booth_preference);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>