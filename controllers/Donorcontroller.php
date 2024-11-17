<?php
require_once 'models/Donor.php';

class DonorController {
    private $donorModel;

    public function __construct() {
        $this->donorModel = new Donor();
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
}
?>
