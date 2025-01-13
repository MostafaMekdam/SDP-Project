<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Event</title>
</head>
<body>
    <h2>Edit Event</h2>
    <?php if ($event): ?>
        <form action="index.php?controller=event&action=update&id=<?= htmlspecialchars($event['event_id']) ?>" method="POST">
            <label for="name">Event Name:</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($event['name']) ?>" required><br>

            <label for="date">Event Date:</label>
            <input type="date" name="date" id="date" value="<?= htmlspecialchars($event['date']) ?>" required><br>

            <label for="location">Location:</label>
            <input type="text" name="location" id="location" value="<?= htmlspecialchars($event['location']) ?>" required><br>

            <label for="capacity">Capacity:</label>
            <input type="number" name="capacity" id="capacity" value="<?= htmlspecialchars($event['capacity']) ?>" required><br>

            <button type="submit">Update Event</button>
        </form>
    <?php else: ?>
        <p>Event not found.</p>
    <?php endif; ?>
    <a href="index.php?controller=event&action=list">Back to Events</a>
</body>
</html>
