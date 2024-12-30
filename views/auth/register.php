<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    <form method="POST" action="index.php?controller=auth&action=register">
        <label>Username:</label>
        <input type="text" name="username" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <label>Role:</label>
        <select name="role" required>
            <option value="Admin">Admin</option>
            <option value="Donor">Donor</option>
            <option value="Volunteer">Volunteer</option>
        </select><br>
        <button type="submit">Register</button>
    </form>
    <a href="index.php?controller=auth&action=login">Back to Login</a>
</body>
</html>
