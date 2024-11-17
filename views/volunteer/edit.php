<h2>Edit Volunteer</h2>
<form action="index.php?controller=volunteer&action=update&id=<?php echo htmlspecialchars($volunteer['volunteer_id']); ?>" method="POST">
    <label for="person_id">Person ID:</label>
    <input type="text" name="person_id" id="person_id" value="<?php echo htmlspecialchars($volunteer['person_id']); ?>" required><br>
    
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($volunteer['name']); ?>" required><br>
    
    <label for="contact_info">Contact Info:</label>
    <input type="text" name="contact_info" id="contact_info" value="<?php echo htmlspecialchars($volunteer['contact_info']); ?>" required><br>

    <label for="availability">Availability:</label>
    <input type="checkbox" name="availability" id="availability" <?php echo $volunteer['availability'] ? 'checked' : ''; ?>><br>

    <button type="submit">Update Volunteer</button>
</form>
<a href="index.php?controller=volunteer&action=list">Back to Volunteers</a>
