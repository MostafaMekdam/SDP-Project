<?php
require_once 'config/Database.php';
require_once 'models/Beneficiary.php';
require_once 'controllers/BeneficiaryController.php';

// Initialize the database and controller
$db = Database::getInstance(); // Use Singleton method to get the instance
$beneficiaryController = new BeneficiaryController();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Only pass the fields relevant to the Beneficiary table
    $beneficiaryData = [
        'name' => $_POST['name'],
        'need' => $_POST['need']
    ];
    $beneficiaryController->addBeneficiary($beneficiaryData);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Beneficiary</title>
</head>
<body>

<h2>Add Beneficiary</h2>

<form method="post" action="">
    <label>Name:</label>
    <input type="text" name="name" required>
    <br>
    <label>Need:</label>
    <input type="text" name="need" required>
    <br>
    <button type="submit">Add Beneficiary</button>
</form>

</body>
</html>
