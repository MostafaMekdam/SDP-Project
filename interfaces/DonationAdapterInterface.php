<?php

interface DonationAdapterInterface {
    public function getDonationId();
    public function getDonationType();
    public function getDonationAmount();
    public function getDonationDate();
}
