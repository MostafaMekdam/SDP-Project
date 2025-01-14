<!DOCTYPE html>
<html lang="en">
<head>
    <title>Event Attendees</title>
</head>
<body>
    <h1>Attendees for Event ID: <?= htmlspecialchars($eventId) ?></h1>
    <table border="1">
        <thead>
            <tr>
                <th>Attendee ID</th>
                <th>Ticket Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($attendees as $attendee): ?>
                <tr>
                    <td><?= htmlspecialchars($attendee['attendee_id']) ?></td>
                    <td><?= $attendee['ticket_status'] ? 'Confirmed' : 'Pending' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
