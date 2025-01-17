<!DOCTYPE html>
<html lang="en">
<head>
    <title>Donor List</title>
</head>
<body>
    <h1>Donors</h1>
    <a href="/donor/add">Add New Donor</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Contact Info</th>
                <th>Actions</th> <!-- New Column for actions -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($donors as $donor): ?>
            <tr>
                <td><?= htmlspecialchars($donor['donor_id']) ?></td>
                <td><?= htmlspecialchars($donor['name']) ?></td>
                <td><?= htmlspecialchars($donor['contact_info']) ?></td>
                <td>
                    <!-- Add a Send Email button -->
                    <a href="index.php?controller=admin&action=sendEmailToDonor&id=<?= $donor['donor_id'] ?>">Send Email</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
