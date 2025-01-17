<!DOCTYPE html>
<html lang="en">
<head>
    <title>Beneficiary Details</title>
</head>
<body>
    <h1>Beneficiary Details</h1>
    <p><strong>ID:</strong> <?= htmlspecialchars($beneficiary['beneficiary_id']) ?></p>
    <p><strong>Name:</strong> <?= htmlspecialchars($beneficiary['name']) ?></p>
    <p><strong>Need:</strong> <?= htmlspecialchars($beneficiary['need']) ?></p>
    <a href="index.php?controller=beneficiary&action=listBeneficiaries">Back to Beneficiaries List</a>
</body>
</html>
