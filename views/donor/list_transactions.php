<<<<<<< HEAD
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
                    WHEN method = 'bankcard' THEN 'Credit Card'
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
    
        // Delete the donation (refund)
        $result = $this->db->execute(
            "DELETE FROM Donation WHERE donation_id = :donation_id",
            [':donation_id' => $donationId]
        );
    
        if ($result) {
            echo "<script>alert('Transaction refunded successfully.'); window.location.href='index.php?controller=payment&action=listTransactions';</script>";
        } else {
            echo "Error: Failed to refund the transaction.";
        }
    }
    
}
=======
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Transactions</title>
</head>
<body>
    <h1>Manage Transactions</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Donation ID</th>
                <th>Donor ID</th>
                <th>Type</th>
                <th>Payment Method</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Event ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($donations)): ?>
                <?php foreach ($donations as $donation): ?>
                <tr>
                    <td><?= htmlspecialchars($donation['donation_id']) ?></td>
                    <td><?= htmlspecialchars($donation['donor_id']) ?></td>
                    <td><?= htmlspecialchars($donation['type']) ?></td>
                    <td><?= htmlspecialchars($donation['payment_method'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($donation['amount']) ?></td>
                    <td><?= htmlspecialchars($donation['date']) ?></td>
                    <td><?= htmlspecialchars($donation['event_id'] ?? 'N/A') ?></td>
                    <td>
                        <a href="index.php?controller=payment&action=processRefund&donation_id=<?= $donation['donation_id'] ?>">Refund</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No donations found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
>>>>>>> bf306b41ac6bcb70288a283fe9fbf1c47101b7b7
