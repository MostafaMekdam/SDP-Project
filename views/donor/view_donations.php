<h1>Your Donations</h1>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Receipt</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($donations)): ?>
        <?php foreach ($donations as $donation): ?>
        <tr>
            <td><?= htmlspecialchars($donation['donation_id']) ?></td>
            <td><?= htmlspecialchars($donation['type']) ?></td>
            <td>$<?= htmlspecialchars($donation['amount']) ?></td>
            <td><?= htmlspecialchars($donation['date']) ?></td>
            <td>
                <a href="index.php?controller=donor&action=downloadReceipt&donationId=<?= $donation['donation_id'] ?>">Download</a>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5" style="text-align: center;">No donations found.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
