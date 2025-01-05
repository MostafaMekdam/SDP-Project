<!DOCTYPE html>
<html lang="en">
<head>
    <title>All Donations</title>
</head>
<body>
    <h1>Manage Donations</h1>
    <table>
        <thead>
            <tr>
                <th>Donation ID</th>
                <th>Type</th>
                <th>Donor ID</th>
                <th>Amount</th>
                <th>Date Issued</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($donations as $donation): ?>
            <tr>
                <td><?= htmlspecialchars($donation['donation_id']) ?></td>
                <td><?= htmlspecialchars($donation['type']) ?></td>
                <td><?= htmlspecialchars($donation['donor_id']) ?></td>
                <td><?= htmlspecialchars($donation['amount']) ?></td>
                <td><?= htmlspecialchars($donation['date_issued']) ?></td>
                <td>
                    <a href="/admin/viewDonor/<?= $donation['donor_id'] ?>">View Donor</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
