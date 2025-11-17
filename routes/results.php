<?php
session_start();
include('../api/connect.php');

// Fetch election results from the database
$groups = mysqli_query($connect, "SELECT name, votes, photo FROM user WHERE role=2");

if ($groups === false) {
    die(mysqli_error($connect)); // Display any database errors
}

$groupsdata = mysqli_fetch_all($groups, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Election Results</title>
    <link rel="stylesheet" href="../css/stylesheet.css">
</head>
<body>
    <h1>Election Results</h1>

    <table>
        <thead>
            <tr>
                <th>Candidate</th>
                <th>Votes</th>
                <th>Photo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($groupsdata as $candidate): ?>
                <tr>
                    <td><?php echo htmlspecialchars($candidate['name']); ?></td>
                    <td><?php echo htmlspecialchars($candidate['votes']); ?></td>
                    <td><img src="../uploads/<?php echo htmlspecialchars($candidate['photo']); ?>" alt="<?php echo htmlspecialchars($candidate['name']); ?>" width="50"></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
