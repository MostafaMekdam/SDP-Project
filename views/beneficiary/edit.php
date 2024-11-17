<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Beneficiary</title>
</head>
<body>
    <h1>Edit Beneficiary</h1>
    <form method="post" action="/beneficiary/edit/<?= $beneficiary['beneficiary_id'] ?>">
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($beneficiary['name']) ?>" required>
        <br>
        <label>Need:</label>
        <input type="text" name="need" value="<?= htmlspecialchars($beneficiary['need']) ?>" required>
        <br>
        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
