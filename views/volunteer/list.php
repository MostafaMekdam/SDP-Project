<!DOCTYPE html>
<html lang="en">
<head>
    <title>Volunteer List</title>
</head>
<body>
    <h1>Volunteers</h1>
    <a href="views/volunteer/add.php">Add New Volunteer</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Contact Info</th>
                <th>Assigned Tasks</th>
                <th>Actions</th> <!-- New Column for actions -->
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($volunteers)) : ?>
                <?php foreach ($volunteers as $volunteer): ?>
                <tr>
                    <td><?= htmlspecialchars($volunteer['volunteer_id']) ?></td>
                    <td><?= htmlspecialchars($volunteer['name']) ?></td>
                    <td><?= htmlspecialchars($volunteer['contact_info']) ?></td>
                    <td><?= htmlspecialchars($volunteer['assigned_tasks'] ?? 'No tasks assigned') ?></td>
                    <td>
                        <!-- Add a Send Email button -->
                        <a href="index.php?controller=admin&action=sendEmailToVolunteer&id=<?= $volunteer['volunteer_id'] ?>">Send Email</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No volunteers found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
