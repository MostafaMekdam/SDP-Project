<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #99c2ff, #5d8aa8);
        }

        .container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            padding: 20px 40px;
            max-width: 600px;
            width: 100%;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            color: #555;
            line-height: 1.5;
        }

        p strong {
            color: #333;
        }

        .not-found {
            color: #999;
            text-align: center;
            font-style: italic;
            margin-top: 20px;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        a {
            display: inline-block;
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
            margin: 5px 10px;
            padding: 10px 20px;
            background-color: #f2f2f2;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        a:hover {
            background-color: #e9ecef;
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
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
            <p class="not-found">Event not found.</p>
        <?php endif; ?>

        <div class="button-container">
            <a href="index.php?controller=event&action=list">Back to Events List</a>
            <?php if ($event): ?>
                <a href="index.php?controller=event&action=listVolunteers&event_id=<?= htmlspecialchars($event['event_id']) ?>">View Volunteer Attendees</a>
                <a href="index.php?controller=admin&action=viewReport&event_id=<?= htmlspecialchars($event['event_id']) ?>">View Report</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
