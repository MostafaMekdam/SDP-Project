<!DOCTYPE html>
<html lang="en">

<head>
    <title>Event List</title>
</head>

<body>
    <h1>Events</h1>
    <a href="index.php?controller=event&action=add">Add New Event</a>
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
                    <a href="index.php?controller=event&action=view&id=<?= $event['event_id'] ?>">View</a>
                    <a href="index.php?controller=event&action=edit&id=<?= $event['event_id'] ?>">Edit</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>