<!DOCTYPE html>
<html lang="en">
<head>
    <title>Event Details</title>
</head>
<body>
    <h1>Event Details</h1>
    <p><strong>ID:</strong> <?= htmlspecialchars($event['event_id']) ?></p>
    <p><strong>Name:</strong> <?= htmlspecialchars($event['name']) ?></p>
    <p><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
    <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
    <a href="index.php?controller=event&action=edit&id=<?= $event['event_id'] ?>">Edit</a>
    <a href="index.php?controller=event&action=list">Back to Events List</a>
</body>
</html>
