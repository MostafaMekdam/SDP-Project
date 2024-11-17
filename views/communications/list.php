<!DOCTYPE html>
<html lang="en">
<head>
    <title>Communication List</title>
</head>
<body>
    <h1>Communications</h1>
    <a href="/communication/add">Send New Communication</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Message</th>
            <th>Type</th>
            <th>Recipient</th>
            <th>Date Sent</th>
        </tr>
        <?php foreach ($communications as $communication): ?>
        <tr>
            <td><?= htmlspecialchars($communication['communication_id']) ?></td>
            <td><?= htmlspecialchars($communication['message']) ?></td>
            <td><?= htmlspecialchars($communication['type']) ?></td>
            <td><?= htmlspecialchars($communication['recipient']) ?></td>
            <td><?= htmlspecialchars($communication['date_sent']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
