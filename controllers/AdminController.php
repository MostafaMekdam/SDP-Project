<?php
require_once 'models/Donation.php';
require_once 'models/Donor.php';
require_once 'EventManagementFacade.php';

class AdminController {
    private $donationModel;
    private $donorModel;
    private $eventFacade;

    public function __construct() {
        $this->donationModel = new Donation();
        $this->donorModel = new Donor();
        $this->eventFacade = new EventManagementFacade(); // Initialize the EventManagementFacade
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
    public function viewReport($params) {
        $eventId = $params['event_id'] ?? null;

        if (!$eventId) {
            echo "Error: Event ID is required.";
            return;
        }

        // Generate the report using the facade
        $report = $this->eventFacade->generateReport($eventId);
        $event = $this->eventFacade->getEventDetails($eventId);

        include 'C:\xampp\htdocs\projects\MVC\SDP-Project\views\event\view_report.php'; // Load the report view
    }
    
}
