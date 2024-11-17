<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add New Donor</title>
</head>
<body>
    <h1>Add New Donor</h1>
    <form method="post" action="/donor/add">
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
