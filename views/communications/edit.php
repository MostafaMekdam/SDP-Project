<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Communication</title>
</head>
<body>
    <h2>Edit Communication</h2>
    <form action="index.php?controller=communication&action=update&id=<?php echo htmlspecialchars($communication['communication_id']); ?>" method="POST">
        <label for="message">Message:</label>
        <textarea name="message" id="message" required><?php echo htmlspecialchars($communication['message']); ?></textarea><br>

        <label for="type">Type:</label>
        <input type="text" name="type" id="type" value="<?php echo htmlspecialchars($communication['type']); ?>" required><br>

        <label for="recipient">Recipient:</label>
        <input type="text" name="recipient" id="recipient" value="<?php echo htmlspecialchars($communication['recipient']); ?>" required><br>

        <button type="submit">Update Communication</button>
    </form>
    <a href="index.php?controller=communication&action=list">Back to Communications</a>
</body>
</html>
