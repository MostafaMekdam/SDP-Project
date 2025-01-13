<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add New Beneficiary</title>
</head>
<body>
    <h1>Add New Beneficiary</h1>
    <form method="post" action="index.php?controller=beneficiary&action=addBeneficiary">
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
