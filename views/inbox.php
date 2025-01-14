<!DOCTYPE html>
<html lang="en">
<head>
    <title>Inbox</title>
</head>
<body>
    <h1>My Inbox</h1>
    <table>
        <tr>
            <th>Message</th>
            <th>Timestamp</th>
            <th>Status</th>
        </tr>
        <?php foreach ($notifications as $notification): ?>
        <tr>
            <td><?= htmlspecialchars($notification['message']) ?></td>
            <td><?= htmlspecialchars($notification['timestamp']) ?></td>
            <td><?= $notification['is_read'] ? 'Read' : 'Unread' ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
