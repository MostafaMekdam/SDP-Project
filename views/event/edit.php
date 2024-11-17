<h2>Edit Event</h2>
<form action="index.php?controller=event&action=update&id=<?php echo $event['event_id']; ?>" method="POST">
    <label for="name">Event Name:</label>
    <input type="text" name="name" id="name" value="<?php echo $event['name']; ?>" required><br>

    <label for="date">Event Date:</label>
    <input type="date" name="date" id="date" value="<?php echo $event['date']; ?>" required><br>

    <label for="location">Location:</label>
    <input type="text" name="location" id="location" value="<?php echo $event['location']; ?>" required><br>

    <label for="capacity">Capacity:</label>
    <input type="number" name="capacity" id="capacity" value="<?php echo $event['capacity']; ?>" required><br>

    <button type="submit">Update Event</button>
</form>
<a href="index.php?controller=event&action=list">Back to Events</a>
