<!DOCTYPE html>
<html lang="en">
<head>
    <title>Volunteer Attendees</title>
</head>
<body>
    <h1>Volunteer Attendees for Event</h1>
    
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Contact Info</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($volunteers)): ?>
                <?php foreach ($volunteers as $volunteer): ?>
                    <tr>
                        <td><?= htmlspecialchars($volunteer['name']) ?></td>
                        <td><?= htmlspecialchars($volunteer['contact_info']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">No volunteers have registered for this event yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="index.php?controller=event&action=view&id=<?= htmlspecialchars($_GET['event_id']) ?>">Back to Event Details</a>
</body>
</html>
