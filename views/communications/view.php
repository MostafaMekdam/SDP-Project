<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Communication</title>
</head>
<body>
    <h2>View Communication</h2>
    <p><strong>Message:</strong> <?php echo htmlspecialchars($communication['message']); ?></p>
    <p><strong>Type:</strong> <?php echo htmlspecialchars($communication['type']); ?></p>
    <p><strong>Recipient:</strong> <?php echo htmlspecialchars($communication['recipient']); ?></p>
    <p><strong>Date Sent:</strong> <?php echo htmlspecialchars($communication['date_sent']); ?></p>

    <a href="index.php?controller=communication&action=edit&id=<?php echo htmlspecialchars($communication['communication_id']); ?>">Edit</a>
    <a href="index.php?controller=communication&action=list">Back to Communications</a>
</body>
</html>
