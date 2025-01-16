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
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($events as $event): 
            $eventObj = new Event($event); // Instantiate Event object to use state behavior
        ?>
            <tr>
                <td><?= htmlspecialchars($event['event_id']) ?></td>
                <td><?= htmlspecialchars($event['name']) ?></td>
                <td><?= htmlspecialchars($event['date']) ?></td>
                <td><?= htmlspecialchars($event['location']) ?></td>
                <td><?= htmlspecialchars($eventObj->viewDetails()) ?></td>
                <td>
                    <?php if (strpos($eventObj->viewDetails(), 'is open for registration.') !== false): ?>
                        <a href="index.php?controller=event&action=register&event_id=<?= $event['event_id'] ?>"
                            onclick="return confirm('Are you sure you want to register for this event?')">Register</a>
                    <?php else: ?>
                        <span>Registration Closed</span>
                    <?php endif; ?>
                    <a href="index.php?controller=event&action=unregister&event_id=<?= $event['event_id'] ?>"
                        onclick="return confirm('Are you sure you want to unregister from this event?')">Unregister</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="index.php">Back to Dashboard</a>
</body>

</html>
