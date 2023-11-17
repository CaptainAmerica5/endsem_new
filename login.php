<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    require_once "database.php";
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($user) {
        if (password_verify($password, $user["password"])) {
            $_SESSION["user"] = "yes";

            // Prepare the data to send as JSON
            $responseData = array(
                'status' => 'success',
                'message' => 'Login successful',
                'userDetails' => $user
            );

            // Send the JSON response
            header('Content-Type: application/json');
            echo json_encode($responseData);
            exit;
        } else {
            $responseData = array('status' => 'error', 'message' => 'Password does not match');
        }
    } else {
        $responseData = array('status' => 'error', 'message' => 'Email does not match');
    }

    // Send the JSON response for errors
    header('Content-Type: application/json');
    echo json_encode($responseData);
    exit;
}
?>

        <form action="login.php" method="post" id="loginForm">
        <div class="form-group">
            <input type="email" placeholder="Enter Email:" name="email" class="form-control">
        </div>
        <div class="form-group">
            <input type="password" placeholder="Enter Password:" name="password" class="form-control">
        </div>
        <div class="form-btn">
            <input type="submit" value="Login" name="login" class="btn btn-primary">
        </div>
        </form>

        <div><p>Not registered yet <a href="registration.php">Register Here</a></p></div>

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#loginForm').submit(function (e) {
                    e.preventDefault();

                    // Perform AJAX request to login.php
                    $.ajax({
                        type: 'POST',
                        url: 'login.php',
                        data: $('#loginForm').serialize(),
                        dataType: 'json',
                        success: function (response) {
                            // Handle the response
                            if (response.status === 'success') {
                                alert(response.message);
                                console.log(response.userDetails); // You can access user details here
                                // Redirect or perform any other actions as needed
                                window.location.href = 'Userinput.html';
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function () {
                            alert('An error occurred during the AJAX request.');
                        }
                    });
                });
            });
        </script>
    </div>
</body>
</html>
