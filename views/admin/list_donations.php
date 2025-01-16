<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Donations</title>
</head>
<body>
    <h1>All Donations</h1>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Donation ID</th>
                <th>Type</th>
                <th>Donor ID</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($donations as $donation): ?>
            <tr>
                <td><?= htmlspecialchars($donation['donation_id']) ?></td>
                <td><?= htmlspecialchars($donation['type']) ?></td>
                <td><?= htmlspecialchars($donation['donor_id']) ?></td>
                <td>$<?= number_format(htmlspecialchars($donation['amount']), 2) ?></td>
                <td><?= htmlspecialchars($donation['date']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
