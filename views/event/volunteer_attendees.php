<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Attendees</title>
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

        td[colspan] {
            text-align: center;
            color: #999;
            font-style: italic;
        }

        a {
            display: inline-block;
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
            margin: 15px 5px 0;
            text-align: center;
        }

        a:hover {
            color: #0056b3;
        }

        .button-container {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Volunteer Attendees for Event</h1>

        <table>
            <thead>
                <tr>
                    <th>Volunteer ID</th>
                    <th>Name</th>
                    <th>Contact Info</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($volunteers)): ?>
                    <?php foreach ($volunteers as $volunteer): ?>
                        <tr>
                            <td><?= htmlspecialchars($volunteer['volunteer_id']) ?></td>
                            <td><?= htmlspecialchars($volunteer['name']) ?></td>
                            <td><?= htmlspecialchars($volunteer['contact_info']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No volunteers have registered for this event yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="button-container">
            <a href="index.php?controller=event&action=view&id=<?= htmlspecialchars($_GET['event_id']) ?>">Back to Event Details</a>
            <a href="index.php?controller=volunteer&action=assignTasks&event_id=<?= htmlspecialchars($_GET['event_id']) ?>">Assign Tasks to Volunteers</a>
        </div>
    </div>
</body>
</html>
