<?php

require_once 'models/Donation.php';
require_once 'config/Database.php';
require_once 'utils.php'; // Include the utility functions

class PaymentController {
    private $db;
    private $donationModel;

    public function __construct() {
        $this->db = Database::getInstance(); // Initialize the database connection
        $this->donationModel = new Donation(); // Initialize the Donation model
    }

    /**
     * List all transactions for the admin.
     */
    public function listTransactions() {
        checkRole('Admin'); // Ensure only Admin can access this feature

        // Fetch all transactions ordered by date
        $transactions = $this->db->query("SELECT * FROM Transactions ORDER BY date DESC");

        // Path to the view file
        $viewPath = realpath(__DIR__ . '/../views/donor/list_transactions.php');
        
        if ($viewPath === false) {
            // Handle missing view file
            echo "Error: The view file for listing transactions was not found.";
            return;
        }

        // Include the view file
        include $viewPath;
    }

    /**
     * Process a refund for a specific transaction.
     *
     * @param array $params Array containing the transaction ID to refund.
     */
    public function processRefund($params) {
        checkRole('Admin'); // Ensure only Admin can process refunds

        $transactionId = $params['transaction_id'] ?? null;

        if (!$transactionId) {
            echo "Error: Transaction ID is required.";
            return;
        }

        // Check if the transaction exists
        $transaction = $this->db->query(
            "SELECT * FROM Transactions WHERE transaction_id = :transaction_id",
            [':transaction_id' => $transactionId]
        );

        if (empty($transaction)) {
            echo "Error: Transaction not found.";
            return;
        }

        // Mark the transaction as refunded
        $result = $this->db->execute(
            "UPDATE Transactions SET refunded = 1 WHERE transaction_id = :transaction_id",
            [':transaction_id' => $transactionId]
        );

        if ($result) {
            echo "Refund processed successfully for Transaction ID $transactionId.";
        } else {
            echo "Error processing refund.";
        }
    }
}
