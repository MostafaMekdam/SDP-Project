<!DOCTYPE html>
<html lang="en">

<head>
    <title>Donations</title>
</head>

<body>
    <h1>Donations</h1>

    <!-- Sorting Form -->
    <form method="GET" action="index.php">
        <input type="hidden" name="controller" value="admin">
        <input type="hidden" name="action" value="listDonations">
        <label for="sort_by">Sort By:</label>
        <select name="sort_by" id="sort_by">
            <option value="donation_id">Donation ID</option>
            <option value="type">Type</option>
            <option value="donor_id">Donor ID</option>
            <option value="amount">Amount</option>
            <option value="date">Date</option>
        </select>
        <select name="order">
            <option value="ASC">Ascending</option>
            <option value="DESC">Descending</option>
        </select>
        <button type="submit">Sort</button>
    </form>

    <!-- Donations Table -->
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

    <!-- Total Donations -->
    <h3>Total Donations: $<?= number_format($totalAmount, 2) ?></h3>

    <!-- Link to Download Report -->
    <a href="index.php?controller=admin&action=generateReport" class="button">Download Donations Report</a>

    <!-- Donation Details -->
    <h1>Donation Details</h1>
    <p>Donation ID: <?= $donationAdapter->getDonationId() ?></p>
    <p>Type: <?= $donationAdapter->getDonationType() ?></p>
    <p>Amount: $<?= $donationAdapter->getDonationAmount() ?></p>
    <p>Date: <?= $donationAdapter->getDonationDate() ?></p>

</body>

</html>
