<!DOCTYPE html>
<html lang="en">
<head>
    <title>Event Details</title>
</head>
<body>
    <h1>Event Details</h1>
    <?php if ($event): 
        $eventObj = new Event($event); // Instantiate Event object to leverage state
    ?>
        <p><strong>ID:</strong> <?= htmlspecialchars($event['event_id']) ?></p>
        <p><strong>Name:</strong> <?= htmlspecialchars($event['name']) ?></p>
        <p><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
        <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
        <p><strong>Capacity:</strong> <?= htmlspecialchars($event['capacity']) ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($eventObj->viewDetails()) ?></p>
    <?php else: ?>
        <p>Event not found.</p>
    <?php endif; ?>
    <a href="index.php?controller=event&action=list">Back to Events List</a>
    <?php if ($event): ?>
        <a href="index.php?controller=event&action=listVolunteers&event_id=<?= htmlspecialchars($event['event_id']) ?>">View Volunteer Attendees</a>
        <a href="index.php?controller=admin&action=viewReport&event_id=<?= htmlspecialchars($event['event_id']) ?>">View Report</a>
    <?php endif; ?>
</body>
</html>
