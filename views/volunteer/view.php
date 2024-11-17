<h2>View Volunteer</h2>
<p><strong>Volunteer ID:</strong> <?php echo htmlspecialchars($volunteer['volunteer_id']); ?></p>
<p><strong>Person ID:</strong> <?php echo htmlspecialchars($volunteer['person_id']); ?></p>
<p><strong>Name:</strong> <?php echo htmlspecialchars($volunteer['name']); ?></p>
<p><strong>Contact Info:</strong> <?php echo htmlspecialchars($volunteer['contact_info']); ?></p>
<p><strong>Availability:</strong> <?php echo $volunteer['availability'] ? 'Available' : 'Not Available'; ?></p>

<a href="index.php?controller=volunteer&action=edit&id=<?php echo htmlspecialchars($volunteer['volunteer_id']); ?>">Edit</a>
<a href="index.php?controller=volunteer&action=list">Back to Volunteers</a>
