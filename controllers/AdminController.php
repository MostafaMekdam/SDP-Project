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

    // List all donations with integrated report and sorting
    public function listDonations($params = []) {
        try {
            $column = $params['column'] ?? 'date';
            $order = $params['order'] ?? 'DESC';

            // Fetch sorted donations
            $donations = $this->donationModel->getSortedDonations($column, $order);

            // Calculate the total amount for the report
            $totalAmount = 0;
            foreach ($donations as $donation) {
                $totalAmount += $donation['amount'];
            }

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

    // View event-specific report
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

    // Generate donations report for download
    public function generateReport() {
        try {
            $donations = $this->donationModel->getAllDonations(); // Fetch all donation data
            $totalAmount = 0;

            // Calculate the total donation amount
            foreach ($donations as $donation) {
                $totalAmount += $donation['amount'];
            }

            // Generate CSV content
            $filename = "donations_report_" . date('Y-m-d') . ".csv";
            header("Content-Type: text/csv");
            header("Content-Disposition: attachment; filename=$filename");

            $output = fopen("php://output", "w");
            fputcsv($output, ['Donation ID', 'Type', 'Donor ID', 'Amount', 'Date']);

            foreach ($donations as $donation) {
                fputcsv($output, $donation);
            }

            // Add total amount at the end of the CSV
            fputcsv($output, []);
            fputcsv($output, ['Total Donations', '', '', $totalAmount]);

            fclose($output);
            exit;
        } catch (Exception $e) {
            error_log("Error generating donation report: " . $e->getMessage());
            echo "An error occurred while generating the report.";
        }
    }
}
