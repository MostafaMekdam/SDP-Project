<!DOCTYPE html>
<html lang="en">
<head>
    <title>Transactions</title>
</head>
<body>
    <h1>Manage Transactions</h1>
    <table>
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Donation ID</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Refunded</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td><?= htmlspecialchars($transaction['transaction_id']) ?></td>
                <td><?= htmlspecialchars($transaction['donation_id']) ?></td>
                <td><?= htmlspecialchars($transaction['amount']) ?></td>
                <td><?= htmlspecialchars($transaction['date']) ?></td>
                <td><?= $transaction['refunded'] ? 'Yes' : 'No' ?></td>
                <td>
                    <?php if (!$transaction['refunded']): ?>
                        <a href="index.php?controller=payment&action=processRefund&transaction_id=<?= $transaction['transaction_id'] ?>">Process Refund</a>
                    <?php else: ?>
                        Refunded
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
