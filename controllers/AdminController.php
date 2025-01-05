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
        $donations = $this->donationModel->getAllDonations();
        require 'views/admin/donations.php';
    }

    // View details of a specific donor
    public function viewDonor($donorId) {
        $donor = $this->donorModel->getDonorById($donorId);
        $transactions = $this->donationModel->getDonorTransactions($donorId);
        require 'views/admin/donor_details.php';
    }
}
