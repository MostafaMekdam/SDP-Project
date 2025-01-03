<!DOCTYPE html>
<html lang="en">
<head>
    <title>Donor List</title>
</head>
<body>
    <h1>Donors</h1>
    <a href="/donor/add">Add New Donor</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Contact Info</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($donors as $donor): ?>
        <tr>
            <td><?= htmlspecialchars($donor['donor_id']) ?></td>
            <td><?= htmlspecialchars($donor['name']) ?></td>
            <td><?= htmlspecialchars($donor['contact_info']) ?></td>
            <td>
                <a href="/donor/view/<?= $donor['donor_id'] ?>">View</a>
                <a href="/donor/edit/<?= $donor['donor_id'] ?>">Edit</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
