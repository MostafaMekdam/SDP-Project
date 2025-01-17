<!-- views/dashboard.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Non-Profit Management System</title>
    <!-- Include Bootstrap or any CSS framework if you want -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { padding-top: 50px; }
        .dashboard { max-width: 800px; margin: 0 auto; }
        .dashboard h1 { margin-bottom: 30px; }
        .dashboard a { display: block; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container dashboard">
        <h1>Non-Profit Management System Dashboard</h1>
        <?php if (!empty($links)): ?>
            <ul class="list-group">
                <?php foreach ($links as $link): ?>
                    <li class="list-group-item">
                        <a href="<?= htmlspecialchars($link['url']) ?>">
                            <?= htmlspecialchars($link['label']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No dashboard items available.</p>
        <?php endif; ?>
        <br>
        <a href="?controller=auth&action=logout" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>
