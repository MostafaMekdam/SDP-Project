<h1>Add Donation</h1>
<form method="POST" action="index.php?controller=donor&action=addDonation">
    <input type="hidden" name="event_id" value="<?= htmlspecialchars($_GET['eventId'] ?? '') ?>">
    <label>Type:</label>
    <input type="text" name="type" required><br>
    <label>Amount:</label>
    <input type="number" name="amount" step="0.01" required><br>
    <button type="submit">Add Donation</button>
</form>
