<!-- layout.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Non-Profit Organization</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Non-Profit Organization Management</h1>
        <nav>
            <ul>
                <li><a href="index.php?controller=donor&action=list">Donors</a></li>
                <li><a href="index.php?controller=volunteer&action=list">Volunteers</a></li>
                <li><a href="index.php?controller=event&action=list">Events</a></li>
                <li><a href="index.php?controller=communication&action=list">Communications</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <?php include($content); ?>
    </main>

    <footer>
        <p>&copy; 2024 Non-Profit Organization. All rights reserved.</p>
    </footer>
</body>
</html>
