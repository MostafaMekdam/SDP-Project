<?php
require_once 'config/Database.php';
require_once 'models/Donor.php';
require_once 'controllers/DonorController.php';

// Initialize the controller
$donorController = new DonorController();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Only pass the fields relevant to the Donor table
    $donorData = [
        'name' => $_POST['name'],
        'contact_info' => $_POST['contact_info']
    ];
    $donorController->addDonor($donorData);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Donor</title>
</head>
<body>

<h2>Add Donor</h2>

<form method="post" action="">
    <label>Name:</label>
    <input type="text" name="name" required>
    <br>
    <label>Contact Info:</label>
    <input type="text" name="contact_info" required>
    <br>
    <button type="submit">Add Donor</button>
</form>

</body>
</html>
