<!DOCTYPE html>
<html lang="en">
<head>
    <title>Send New Communication</title>
</head>
<body>
    <h1>Send New Communication</h1>
    <form method="post" action="/communication/add">
        <label>Message:</label>
        <textarea name="message" required></textarea>
        <br>
        <label>Type:</label>
        <select name="type">
            <option value="email">Email</option>
            <option value="sms">SMS</option>
            <option value="social_media">Social Media</option>
        </select>
        <br>
        <label>Recipient:</label>
        <input type="text" name="recipient" required>
        <br>
        <button type="submit">Send</button>
    </form>
</body>
</html>
