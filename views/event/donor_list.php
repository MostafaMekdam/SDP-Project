<h1>Upcoming Events</h1>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Date</th>
            <th>Location</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($events as $event): ?>
        <tr>
            <td><?= htmlspecialchars($event['event_id']) ?></td>
            <td><?= htmlspecialchars($event['name']) ?></td>
            <td><?= htmlspecialchars($event['date']) ?></td>
            <td><?= htmlspecialchars($event['location']) ?></td>
            <td>
                <a href="index.php?controller=donor&action=addDonation&eventId=<?= $event['event_id'] ?>">Contribute</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
