<!DOCTYPE html>
<html lang="en">
<head>
    <title>Volunteer Events</title>
</head>
<body>
    <h1>Available Events</h1>
    <p>Browse the events and register for those you wish to participate in.</p>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Date</th>
            <th>Location</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($events as $event): ?>
        <tr>
            <td><?= htmlspecialchars($event['event_id']) ?></td>
            <td><?= htmlspecialchars($event['name']) ?></td>
            <td><?= htmlspecialchars($event['date']) ?></td>
            <td><?= htmlspecialchars($event['location']) ?></td>
            <td>
                <a href="index.php?controller=event&action=register&event_id=<?= $event['event_id'] ?>">Register</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="index.php">Back to Dashboard</a>
</body>
</html>
