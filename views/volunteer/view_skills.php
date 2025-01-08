<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Skills</title>
</head>
<body>
    <h1>My Skills</h1>
    <?php if (empty($skills)): ?>
        <p>You have not added any skills yet.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($skills as $skill): ?>
                <li><?= htmlspecialchars($skill['skill_name']) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <a href="index.php?controller=volunteer&action=chooseSkills">Add More Skills</a>
</body>
</html>
