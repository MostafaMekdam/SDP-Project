<?php

require_once 'models/Donation.php';
require_once 'interfaces/DonationAdapterInterface.php';

class DonationAdapter implements DonationAdapterInterface {
    private $donation;

    public function __construct(Donation $donation) {
        $this->donation = $donation;
    }

    public function getDonationId() {
        return $this->donation->getData()['id'];
    }

    public function getDonationType() {
        return $this->donation->getData()['type'];
    }

    public function getDonationAmount() {
        return $this->donation->getData()['amount'];
    }

    public function getDonationDate() {
        return $this->donation->getData()['date'];
    }
}
