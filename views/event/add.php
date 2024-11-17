<h2>Add New Event</h2>
<form action="index.php?controller=event&action=store" method="POST">
    <label for="name">Event Name:</label>
    <input type="text" name="name" id="name" required><br>

    <label for="date">Event Date:</label>
    <input type="date" name="date" id="date" required><br>

    <label for="location">Location:</label>
    <input type="text" name="location" id="location" required><br>

    <label for="capacity">Capacity:</label>
    <input type="number" name="capacity" id="capacity" required><br>

    <button type="submit">Create Event</button>
</form>
<a href="index.php?controller=event&action=list">Back to Events</a>
