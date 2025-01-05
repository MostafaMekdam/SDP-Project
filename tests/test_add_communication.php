<?php
require_once 'config/Database.php';
require_once 'models/Communication.php';
require_once 'controllers/CommunicationController.php';

// Initialize the controller
$communicationController = new CommunicationController();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Only pass the fields relevant to the Communication table
    $communicationData = [
        'message' => $_POST['message'],
        'type' => $_POST['type'],
        'recipient' => $_POST['recipient'],
        'date_sent' => date('Y-m-d')
    ];
    $communicationController->sendMessage($communicationData);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Send Communication</title>
</head>
<body>

<h2>Send Communication</h2>

<form method="post" action="">
    <label>Message:</label>
    <textarea name="message" required></textarea>
    <br>
    <label>Type:</label>
    <select name="type" required>
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
