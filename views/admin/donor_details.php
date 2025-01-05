<!DOCTYPE html>
<html lang="en">
<head>
    <title>Donor Details</title>
</head>
<body>
    <h1>Donor Details</h1>
    <p><strong>ID:</strong> <?= htmlspecialchars($donor['donor_id']) ?></p>
    <p><strong>Name:</strong> <?= htmlspecialchars($donor['name']) ?></p>
    <p><strong>Contact Info:</strong> <?= htmlspecialchars($donor['contact_info']) ?></p>

    <h2>Transaction History</h2>
    <table>
        <thead>
            <tr>
                <th>Donation ID</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Date Issued</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td><?= htmlspecialchars($transaction['donation_id']) ?></td>
                <td><?= htmlspecialchars($transaction['type']) ?></td>
                <td><?= htmlspecialchars($transaction['amount']) ?></td>
                <td><?= htmlspecialchars($transaction['date_issued']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

