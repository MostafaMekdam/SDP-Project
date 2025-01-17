<!DOCTYPE html>
<html lang="en">
<head>
    <title>Assign Tasks to Volunteers</title>
</head>
<body>
    <h1>Assign Tasks for Event</h1>

    <form action="index.php?controller=volunteer&action=saveAssignedTasks" method="POST">
        <input type="hidden" name="event_id" value="<?= htmlspecialchars($_GET['event_id']) ?>">

        <table>
            <thead>
                <tr>
                    <th>Volunteer</th>
                    <th>Task</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($volunteers as $volunteer): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($volunteer['name']) ?>
                            <input type="hidden" name="volunteers[]" value="<?= $volunteer['volunteer_id'] ?>">
                        </td>
                        <td>
                            <select name="tasks[<?= $volunteer['volunteer_id'] ?>]">
                                <option value="">-- Select Task --</option>
                                <?php foreach ($tasks as $task): ?>
                                    <option value="<?= $task['task_id'] ?>"><?= htmlspecialchars($task['description']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button type="submit">Save Assignments</button>
    </form>
</body>
</html>
