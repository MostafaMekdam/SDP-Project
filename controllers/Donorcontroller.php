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
    
        // Assuming `user_id` in `donor` table matches `user_id` in session
        $userId = $_SESSION['user_id'];
        $query = "SELECT donor_id FROM Donor WHERE user_id = :user_id";
        $result = $this->db->query($query, [':user_id' => $userId]);
    
        if (empty($result)) {
            throw new Exception("No donor associated with the logged-in user.");
        }
    
        return $result[0]['donor_id']; // Assuming the query returns at least one result
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
    
            // Verify the donor exists
            $query = "SELECT COUNT(*) AS count FROM Donor WHERE donor_id = :donor_id";
            $result = $this->db->query($query, [':donor_id' => $donorId]);
            if ($result[0]['count'] == 0) {
                echo "Error: Donor does not exist. Please contact the administrator.";
                return;
            }
    
            $type = $_POST['type'];
            $amount = $_POST['amount'];
            $eventId = $_POST['event_id'] ?? null; // Optional event ID
            $date = date('Y-m-d H:i:s');
    
            // Insert the donation record
            $query = "INSERT INTO Donation (donor_id, event_id, type, amount, date) 
                      VALUES (:donor_id, :event_id, :type, :amount, :date)";
            $params = [
                ':donor_id' => (int)$donorId,
                ':event_id' => $eventId ? (int)$eventId : null,
                ':type' => (string)$type,
                ':amount' => (float)$amount,
                ':date' => (string)$date,
            ];
    
            $result = $this->db->execute($query, $params);
    
            if ($result) {
                // Register the donor as an observer for the event if `event_id` is provided
                if ($eventId) {
                    $observerQuery = "INSERT IGNORE INTO Event_Observers (event_id, user_id) VALUES (:event_id, :user_id)";
                    $this->db->execute($observerQuery, [':event_id' => $eventId, ':user_id' => $_SESSION['user_id']]);
    
                    // Add notification to the inbox table
                    $notificationQuery = "INSERT INTO Inbox (user_id, message, event_id) 
                                          VALUES (:user_id, :message, :event_id)";
                    $notificationParams = [
                        ':user_id' => $_SESSION['user_id'],
                        ':message' => "Thank you for your contribution to event ID $eventId.",
                        ':event_id' => $eventId,
                    ];
                    $this->db->execute($notificationQuery, $notificationParams);
                }
    
                // Redirect to view donations
                header('Location: index.php?controller=donor&action=viewDonations');
                exit;
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

    public function viewInbox() {
        $userId = $_SESSION['user_id']; // Get the logged-in user ID
    
        // Fetch notifications
        $query = "SELECT * FROM Inbox WHERE user_id = :user_id ORDER BY timestamp DESC";
        $notifications = $this->db->query($query, [':user_id' => $userId]);
    
        // Mark all notifications as read
        $this->db->execute("UPDATE Inbox SET is_read = TRUE WHERE user_id = :user_id", [':user_id' => $userId]);
    
        include 'views/inbox.php';
    }
    
    
    
}
?>
