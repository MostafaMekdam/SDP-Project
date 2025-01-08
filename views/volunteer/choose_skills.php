<!DOCTYPE html>
<html lang="en">
<head>
    <title>Choose Skills</title>
</head>
<body>
    <h1>Choose Your Skills</h1>
    <form method="POST" action="index.php?controller=volunteer&action=assignSkills">
        <?php foreach ($skills as $skill): ?>
            <div>
                <input type="checkbox" name="skills[]" value="<?= $skill['skill_id'] ?>" 
                <?= in_array($skill['skill_id'], $volunteerSkills) ? 'checked' : '' ?>>
                <label><?= htmlspecialchars($skill['skill_name']) ?></label>
            </div>
        <?php endforeach; ?>
        <button type="submit">Save Skills</button>
    </form>
</body>
</html>
