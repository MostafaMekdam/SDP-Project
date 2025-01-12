<!DOCTYPE html>
<html lang="en">
<head>
    <title>Volunteer List</title>
</head>
<body>
    <h1>Volunteers</h1>
    <a href="views\volunteer\add.php">Add New Volunteer</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Person ID</th>
            <th>Name</th>
            <th>Contact Info</th>
            <th>Availability</th>
            <th>Actions</th>
        </tr>

        <?php if (!empty($volunteers)) : ?>
            <?php foreach ($volunteers as $volunteer): ?>
           
            <tr>
                <td><?= htmlspecialchars($volunteer['volunteer_id']) ?></td>
                <td> <?php echo $array['person_id'] ?? "Person ID not available"; ?></td>
                <td><?= htmlspecialchars($volunteer['name']) ?></td>
                <td><?= htmlspecialchars($volunteer['contact_info']) ?></td>
                <td><?= $volunteer['availability'] ? 'Available' : 'Not Available' ?></td>
                <td>
                    <a href="/volunteer/view/<?= $volunteer['volunteer_id'] ?>">View</a>
                    <a href="/volunteer/edit/<?= $volunteer['volunteer_id'] ?>">Edit</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No volunteers found.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
