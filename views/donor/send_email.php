<h1>Send Email to Donor</h1>
<form method="POST" action="index.php?controller=admin&action=sendEmailToDonor&id=<?= htmlspecialchars($_GET['id']) ?>">
    <label>Subject:</label>
    <input type="text" name="subject" required><br>
    <label>Body:</label>
    <textarea name="body" required></textarea><br>
    <button type="submit">Send Email</button>
</form>
