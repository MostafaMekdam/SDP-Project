<?php
require_once 'models/Donation.php';
require_once 'models/Donor.php';

class AdminController {
    private $donationModel;
    private $donorModel;

    public function __construct() {
        $this->donationModel = new Donation();
        $this->donorModel = new Donor();
    }

    // List all donations
    public function listDonations() {
        try {
            $donations = $this->donationModel->getAllDonations();
            require 'views/admin/donations.php';
        } catch (Exception $e) {
            error_log("Error fetching donations: " . $e->getMessage());
            echo "An error occurred while fetching donation records.";
        }
    }

    // View details of a specific donor
    public function viewDonor($params) {
        try {
            $donorId = $params['id'] ?? null;
            if (!$donorId) {
                throw new Exception("Invalid donor ID.");
            }

            $donor = $this->donorModel->getDonorById($donorId);
            $transactions = $this->donationModel->getDonorTransactions($donorId);

            if (!$donor) {
                throw new Exception("Donor not found.");
            }

            require 'views/admin/donor_details.php';
        } catch (Exception $e) {
            error_log("Error viewing donor details: " . $e->getMessage());
            echo "An error occurred while fetching donor details.";
        }
    }

    // Generate donation report
    public function generateReport() {
        $donations = $this->donationModel->getAllDonations(); // Fetch all donation data
        $totalAmount = 0;
    
        // Calculate total donation amount
        foreach ($donations as $donation) {
            $totalAmount += $donation['amount'];
        }
    
        require 'views/admin/donation_report.php';
    }
    
}
