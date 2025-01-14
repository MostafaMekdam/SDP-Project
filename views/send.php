<!DOCTYPE html>
<html lang="en">
<head>
    <title>Send Message</title>
</head>
<body>
    <h1>Send Message</h1>
    <form method="POST" action="index.php?controller=communication&action=sendMessage">
        <label for="type">Type:</label>
        <select name="type" id="type" required>
            <option value="email">Email</option>
            <option value="sms">SMS</option>
            <option value="social_media">Social Media</option>
        </select>
        <br>

        <label for="recipient">Recipient:</label>
        <input type="text" name="recipient" id="recipient" required>
        <br>

        <label for="message">Message:</label>
        <textarea name="message" id="message" required></textarea>
        <br>

        <button type="submit">Send</button>
    </form>
</body>
</html>
