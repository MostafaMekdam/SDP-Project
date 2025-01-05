<?php
require_once 'config/Database.php';

class Donation {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Fetch all donations
    public function getAllDonations() {
        $query = "SELECT d.donation_id, d.type, d.donor_id, r.amount, r.date_issued 
                  FROM Donation d
                  LEFT JOIN Receipt r ON d.donation_id = r.donation_id
                  ORDER BY r.date_issued DESC";
        return $this->db->query($query);
    }

    // Fetch transactions for a specific donor
    public function getDonorTransactions($donorId) {
        $query = "SELECT d.donation_id, d.type, r.amount, r.date_issued 
                  FROM Donation d
                  LEFT JOIN Receipt r ON d.donation_id = r.donation_id
                  WHERE d.donor_id = :donor_id
                  ORDER BY r.date_issued DESC";
        return $this->db->query($query, [':donor_id' => $donorId]);
    }
}
