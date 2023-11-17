<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

// Retrieve user details from the session or database, depending on your implementation
$userDetails = $_SESSION["userDetails"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Include any additional styles or scripts needed for your dashboard -->
</head>
<body>
    <h1>Welcome to the Dashboard, <?php echo $userDetails['username']; ?>!</h1>
    <!-- Display other dashboard content or functionality as needed -->

    <p><a href="logout.php">Logout</a></p>
</body>
</html>
