<?php
class Donor implements Observer {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance(); // Use Singleton for database instance
    }

    public function update($eventData) {
        echo "Donor notified about event: " . $eventData['name'] . "\n";
    }

    public function getDonors() {
        $query = "SELECT * FROM donor";
        return $this->db->query($query);
    }

    public function getDonorById($donorId) {
        $query = "SELECT * FROM donor WHERE donor_id = :donor_id";
        return $this->db->query($query, [':donor_id' => $donorId]);
    }

    public function addDonor($donorData) {
        $query = "INSERT INTO donor (name, contact_info) VALUES (:name, :contact_info)";
        return $this->db->execute($query, $donorData);
    }

    public function updateDonor($donorData) {
        $query = "UPDATE donor SET name = :name, contact_info = :contact_info WHERE donor_id = :donor_id";
        return $this->db->execute($query, $donorData);
    }

    public function deleteDonor($donorId) {
        $query = "DELETE FROM donor WHERE donor_id = :donor_id";
        return $this->db->execute($query, [':donor_id' => $donorId]);
    }
}

?>
