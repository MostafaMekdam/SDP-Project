<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage Donations</title>
</head>

<body>
    <h1>Donations</h1>
    <table border="1">
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
                    <td><?= htmlspecialchars($donation['amount']) ?></td>
                    <td><?= htmlspecialchars($donation['date']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>