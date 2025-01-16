<!DOCTYPE html>
<html lang="en">
<head>
    <title>Event Report</title>
</head>
<body>
    <h1>Event Report</h1>
    <p><strong>Event Name:</strong> <?= htmlspecialchars($event['name']) ?></p>
    <p><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
    <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
    <p><strong>Total Volunteers:</strong> <?= htmlspecialchars($report['total_volunteers']) ?></p>
    <p><strong>Total Donations:</strong> $<?= htmlspecialchars(number_format($report['total_donations'], 2)) ?></p>

    <a href="index.php?controller=event&action=view&id=<?= htmlspecialchars($event['event_id']) ?>">Back to Event</a>
</body>
</html>