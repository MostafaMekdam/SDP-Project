<?php
require_once 'config/Database.php';
require_once 'models/Volunteer.php';
require_once 'controllers/VolunteerController.php';

// Initialize the controller
$volunteerController = new VolunteerController();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Only pass the fields relevant to the Volunteer table
    $volunteerData = [
        ':volunteer_id' => $_POST['volunteer_id'],
        ':name' => $_POST['name'],
        ':contact_info' => $_POST['contact_info'],
        ':availability' => isset($_POST['availability']) ? 1 : 0
    ];
    $volunteerController->addVolunteer($volunteerData);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Volunteer</title>
</head>
<body>

<h2>Add Volunteer</h2>

<form method="post" action="">
    <label>Volunteer ID:</label>
    <input type="text" name="volunteer_id" required>
    <br>
    <label>Name:</label>
    <input type="text" name="name" required>
    <br>
    <label>Contact Info:</label>
    <input type="text" name="contact_info" required>
    <br>
    <label>Availability:</label>
    <input type="checkbox" name="availability" value="1">
    <br>
    <button type="submit">Add Volunteer</button>
</form>

</body>
</html>
