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
