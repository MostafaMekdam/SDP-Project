<?php
require_once 'models/Donor.php';

class DonorController {
    private $donorModel;
    private $db;

    public function __construct() {
        $this->donorModel = new Donor();
        $this->db = Database::getInstance();
    }

    private function getLoggedInDonorId() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Donor') {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
        return $_SESSION['user_id'];
    }

    // Adds a new donor
    public function addDonor($data) {
        $data = [
            ':name' => $data['name'],
            ':contact_info' => $data['contact_info']
        ];
        $result = $this->donorModel->addDonor($data);
        echo $result ? "Donor added successfully." : "Error adding donor.";
    }

    // Retrieves donor information
    public function getDonor($donorId) {
        $donor = $this->donorModel->getDonorById($donorId);
        require 'views/donor/view.php';
    }

    // Updates a donor’s details
    public function updateDonor($donorId, $data) {
        $data[':donor_id'] = $donorId;
        $result = $this->donorModel->updateDonor($data);
        echo $result ? "Donor updated successfully." : "Error updating donor.";
    }

    // List all donors
    public function listDonors() {
        $donors = $this->donorModel->getDonors();
        require 'views/donor/list.php';
    }

    public function addDonation() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $donorId = $this->getLoggedInDonorId();
            $type = $_POST['type'];
            $amount = $_POST['amount'];
            $eventId = $_POST['event_id'] ?? null; // Optional event ID
            $date = date('Y-m-d H:i:s');
    
            $query = "INSERT INTO Donation (donor_id, event_id, type, amount, date) 
                      VALUES (:donor_id, :event_id, :type, :amount, :date)";
            $params = [
                ':donor_id' => $donorId,
                ':event_id' => $eventId,
                ':type' => $type,
                ':amount' => $amount,
                ':date' => $date,
            ];
    
            $result = $this->db->execute($query, $params);
    
            if ($result) {
                header('Location: index.php?controller=donor&action=viewDonations');
            } else {
                echo "Error adding donation.";
            }
        } else {
            $eventId = $_GET['eventId'] ?? null; // Passed from "Contribute" button
            include 'views/donor/add_donation.php';
        }
    }
    
    

    public function viewDonations() {
        $donorId = $this->getLoggedInDonorId();
    
        // Fetch donations
        $query = "SELECT * FROM Donation WHERE donor_id = :donor_id";
        $donations = $this->db->query($query, [':donor_id' => $donorId]);
    
        include 'views/donor/view_donations.php';
    }

    public function downloadReceipt($donationId) {
        $query = "SELECT d.*, e.name AS event_name, e.date AS event_date, e.location AS event_location 
                  FROM Donation d
                  LEFT JOIN Event e ON d.event_id = e.event_id
                  WHERE d.donation_id = :donation_id";
        $donation = $this->db->query($query, [':donation_id' => $donationId])[0] ?? null;
    
        if (!$donation) {
            echo "Donation not found.";
            return;
        }
    
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="receipt_' . $donationId . '.html"');
        echo "<h1>Donation Receipt</h1>";
        echo "<p>Donation ID: " . htmlspecialchars($donation['donation_id']) . "</p>";
        echo "<p>Amount: $" . htmlspecialchars($donation['amount']) . "</p>";
        echo "<p>Date: " . htmlspecialchars($donation['date']) . "</p>";
        if ($donation['event_name']) {
            echo "<p>Event: " . htmlspecialchars($donation['event_name']) . "</p>";
            echo "<p>Event Date: " . htmlspecialchars($donation['event_date']) . "</p>";
            echo "<p>Event Location: " . htmlspecialchars($donation['event_location']) . "</p>";
        }
    }
    
}
?>
