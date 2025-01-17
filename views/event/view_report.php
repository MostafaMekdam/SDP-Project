<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Report</title>
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
        <h1>Event Report</h1>
        <p><strong>Event Name:</strong> <?= htmlspecialchars($event['name']) ?></p>
        <p><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
        <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
        <p><strong>Total Volunteers:</strong> <?= htmlspecialchars($report['total_volunteers']) ?></p>
        <p><strong>Total Donations:</strong> $<?= htmlspecialchars(number_format($report['total_donations'], 2)) ?></p>

        <div class="button-container">
            <a href="index.php?controller=event&action=view&id=<?= htmlspecialchars($event['event_id']) ?>">Back to Event</a>
        </div>
    </div>
</body>
</html>
