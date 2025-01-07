<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <script>
        // Dynamically show/hide fields based on the selected role
        function toggleRoleFields() {
            const role = document.querySelector('select[name="role"]').value;
            document.getElementById('donor-fields').style.display = (role === 'Donor') ? 'block' : 'none';
            document.getElementById('volunteer-fields').style.display = (role === 'Volunteer') ? 'block' : 'none';
        }
    </script>
</head>
<body>
    <h1>Register</h1>
    <form method="POST" action="index.php?controller=auth&action=register">
        <label>Username:</label>
        <input type="text" name="username" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <label>Role:</label>
        <select name="role" onchange="toggleRoleFields()" required>
            <option value="">Select Role</option>
            <option value="Admin">Admin</option>
            <option value="Donor">Donor</option>
            <option value="Volunteer">Volunteer</option>
        </select><br>

        <!-- Donor-specific fields -->
        <div id="donor-fields" style="display: none;">
            <label>Contact Info:</label>
            <input type="text" name="contact_info"><br>
        </div>

        <!-- Volunteer-specific fields -->
        <div id="volunteer-fields" style="display: none;">
            <label>Contact Info:</label>
            <input type="text" name="contact_info"><br>
            
            <label>Availability:</label>
            <input type="checkbox" name="availability" value="1"> Available<br>
        </div>

        <button type="submit">Register</button>
    </form>
    <a href="index.php?controller=auth&action=login">Back to Login</a>
</body>
</html>
