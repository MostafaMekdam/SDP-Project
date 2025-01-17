<?php

require_once 'models/Donation.php';
require_once 'config/Database.php';
require_once 'utils.php'; // Include utility functions

class PaymentController {
    private $db;
    private $donationModel;

    public function __construct() {
        $this->db = Database::getInstance(); // Initialize the database connection
        $this->donationModel = new Donation(); // Initialize the Donation model
    }

    
    public function listTransactions() {
        checkRole('Admin'); // Ensure only Admin can access this feature
    
        // Fetch all donations with the payment method (Credit Card or E-Wallet)
        $donations = $this->db->query("
            SELECT 
                d.donation_id,
                d.donor_id,
                d.type,
                d.amount,
                d.date,
                d.event_id,
                CASE 
                    WHEN method = 'CreditCard' THEN 'Credit Card'
                    WHEN method = 'EWallet' THEN 'E-Wallet'
                    ELSE 'Unknown'
                END AS payment_method
            FROM Donation d
            LEFT JOIN Transactions t ON d.donation_id = t.donation_id
            ORDER BY d.date DESC
        ");
    
        // Path to the view file
        $viewPath = realpath(__DIR__ . '/../views/donor/list_transactions.php');
    
        if ($viewPath === false) {
            // Handle missing view file
            echo "Error: The view file for listing transactions was not found.";
            return;
        }
    
        // Pass donations to the view
        include $viewPath;
    }
    

    /**
     * Process refund for a specific donation (if applicable).
     *
     * @param array $params Array containing the donation ID to refund.
     */
    public function processRefund($params) {
        checkRole('Admin'); // Ensure only Admin can process refunds

        $donationId = $params['donation_id'] ?? null;

        if (!$donationId) {
            echo "Error: Donation ID is required.";
            return;
        }

        // Check if the donation exists
        $donation = $this->db->query(
            "SELECT * FROM Donation WHERE donation_id = :donation_id",
            [':donation_id' => $donationId]
        );

        if (empty($donation)) {
            echo "Error: Donation not found.";
            return;
        }

        // Add logic for marking the donation as refunded if needed
        echo "Refund functionality is not implemented in this example.";
    }
}
