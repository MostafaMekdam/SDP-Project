<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beneficiary List</title>
</head>
<body>
    <h1>Beneficiaries</h1>
    <a href="index.php?controller=beneficiary&action=add">Add New Beneficiary</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Need</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($beneficiaries as $beneficiary): ?>
        <tr>
            <td><?= htmlspecialchars($beneficiary['beneficiary_id']) ?></td>
            <td><?= htmlspecialchars($beneficiary['name']) ?></td>
            <td><?= htmlspecialchars($beneficiary['need']) ?></td>
            <td>
                <a href="index.php?controller=beneficiary&action=view&id=<?= $beneficiary['beneficiary_id'] ?>">View</a>
                <a href="index.php?controller=beneficiary&action=edit&id=<?= $beneficiary['beneficiary_id'] ?>">Edit</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
