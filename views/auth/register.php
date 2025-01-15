<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <script>
        // Dynamically show/hide the contact_info field based on the selected role
        function toggleRoleFields() {
            const role = document.querySelector('select[name="role"]').value;
            const contactInfoField = document.getElementById('contact-info-field');

            // Show contact info for Donor and Volunteer roles, hide for Admin
            contactInfoField.style.display = (role === 'Donor' || role === 'Volunteer') ? 'block' : 'none';
        }
    </script>
</head>
<body>
    <h1>Register</h1>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

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

        <!-- Contact Info Field -->
        <div id="contact-info-field" style="display: none;">
            <label>Contact Info:</label>
            <input type="text" name="contact_info" id="contact_info" 
                   value="<?php echo htmlspecialchars($_POST['contact_info'] ?? ''); ?>" required><br>
        </div>

        <button type="submit">Register</button>
    </form>
    <a href="index.php?controller=auth&action=login">Back to Login</a>
</body>
</html>
