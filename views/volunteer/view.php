<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Volunteer</title>
    <style>
        /* General Body Styles */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #a8c0ff, #3f4c6b); /* Soft, neutral gradient */
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
            text-align: center;
        }

        /* Main Container */
        .container {
            background-color: #fff;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: left;
        }

        /* Heading */
        h2 {
            font-size: 28px;
            color: #3f4c6b;
            margin-bottom: 30px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Text Styling */
        p {
            font-size: 16px;
            margin: 10px 0;
            color: #3f4c6b;
        }

        strong {
            color: #5c6e82;
        }

        /* Button Styling */
        a {
            text-decoration: none;
            color: #fff;
            background-color: #5c6e82;
            padding: 8px 15px;
            border-radius: 8px;
            font-size: 16px;
            margin-right: 10px;
            display: inline-block;
            transition: background-color 0.3s, transform 0.3s;
        }

        a:hover {
            background-color: #3f4c6b;
            transform: scale(1.05);
        }

        /* Footer Styles */
        .footer {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
            color: black;
            font-size: 14px;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .container {
                padding: 25px;
            }

            h2 {
                font-size: 24px;
            }

            a {
                font-size: 14px;
            }

            p {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>View Volunteer</h2>
        <p><strong>Volunteer ID:</strong> <?php echo htmlspecialchars($volunteer['volunteer_id']); ?></p>
        <p><strong>Person ID:</strong> <?php echo htmlspecialchars($volunteer['person_id']); ?></p>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($volunteer['name']); ?></p>
        <p><strong>Contact Info:</strong> <?php echo htmlspecialchars($volunteer['contact_info']); ?></p>
        <p><strong>Availability:</strong> <?php echo $volunteer['availability'] ? 'Available' : 'Not Available'; ?></p>

        <a href="index.php?controller=volunteer&action=edit&id=<?php echo htmlspecialchars($volunteer['volunteer_id']); ?>">Edit</a>
        <a href="index.php?controller=volunteer&action=list">Back to Volunteers</a>
    </div>

    <div class="footer">
        <p>&copy; 2025 Your Organization</p>
    </div>

</body>
</html>
