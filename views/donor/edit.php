<!DOCTYPE html>
<html lang="en">
<head>
    <title>Donor Details</title>
</head>
<body>
    <h1>Donor Details</h1>
    <p><strong>ID:</strong> <?= htmlspecialchars($donor['donor_id']) ?></p>
    <p><strong>Name:</strong> <?= htmlspecialchars($donor['name']) ?></p>
    <p><strong>Contact Info:</strong> <?= htmlspecialchars($donor['contact_info']) ?></p>
    <a href="/donor/edit/<?= $donor['donor_id'] ?>">Edit</a>
    <a href="/donors">Back to Donors List</a>
</body>
</html>
