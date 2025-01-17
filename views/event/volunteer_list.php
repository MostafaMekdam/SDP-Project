<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Events</title>
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
            max-width: 800px;
            width: 100%;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            text-align: center;
            color: #555;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 12px 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            color: #555;
        }

        th {
            font-weight: bold;
            background-color: #f2f2f2;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
            margin: 0 5px;
        }

        a:hover {
            color: #0056b3;
        }

        .status-open {
            color: green;
        }

        .status-closed {
            color: red;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #555;
        }

        .back-link:hover {
            color: #333;
        }
    </style>
</head>

<body>
    <div class="container">
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
                    <td class="<?= strpos($eventObj->viewDetails(), 'is open for registration.') !== false ? 'status-open' : 'status-closed' ?>">
                        <?= htmlspecialchars($eventObj->viewDetails()) ?>
                    </td>
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
        <a href="index.php" class="back-link">Back to Dashboard</a>
    </div>
</body>

</html>
