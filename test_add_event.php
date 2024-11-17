<?php
require_once 'config/Database.php';
require_once 'models/Event.php';
require_once 'controllers/EventController.php';

// Initialize the controller
$eventController = new EventController();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Only pass the fields relevant to the Event table
    $eventData = [
        'name' => $_POST['name'],
        'date' => $_POST['date'],
        'location' => $_POST['location'],
        'capacity' => $_POST['capacity']
    ];
    $eventController->store($eventData);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Event</title>
</head>
<body>

<h2>Add Event</h2>

<form method="post" action="">
    <label>Event Name:</label>
    <input type="text" name="name" required>
    <br>
    <label>Event Date:</label>
    <input type="date" name="date" required>
    <br>
    <label>Location:</label>
    <input type="text" name="location" required>
    <br>
    <label>Capacity:</label>
    <input type="number" name="capacity" required>
    <br>
    <button type="submit">Add Event</button>
</form>

</body>
</html>
