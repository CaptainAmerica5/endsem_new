<?php
function checkCustomerExists($pdo, $email) {
    $stmt = $pdo->prepare("SELECT * FROM customers WHERE email = :email");
    $stmt->execute(['email' => $email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Database connection parameters
$host = 'localhost';  // Typically localhost for XAMPP
$db   = 'customer_db'; // Replace with your database name
$user = 'root'; // Default XAMPP username
$pass = ''; // Default XAMPP password is blank
$charset = 'utf8mb4';

// PDO Data Source Name
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer = checkCustomerExists($pdo, $_POST['email']);

    if ($customer) {
        session_start();
        $_SESSION['customerDetails'] = $customer;
        echo json_encode($_SESSION['customerDetails']);
        exit;
    } else {
        echo json_encode(["exists" => false]);
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Details</title>
    <script>
        function checkCustomer() {
            var xhr = new XMLHttpRequest();
            var url = "CustomerInput.php"; // Ensure this matches the file name
            xhr.open("POST", url, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.exists === false) {
                        alert("Customer does not exist.");
                    } else {
                        alert("Customer exists. Details: " + JSON.stringify(response));
                    }
                }
            };

            var formData = new FormData(document.getElementById("customerForm"));
            xhr.send(new URLSearchParams(formData).toString());
        }
    </script>
</head>
<body>
    <form id="customerForm" onsubmit="event.preventDefault(); checkCustomer();">
        Name: <input type="text" name="name" pattern="[A-Za-z ]+" required><br>
        Email: <input type="email" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" required><br>

        Phone: <input type="tel" name="phone" pattern="[069][0-9]{9}" required><br>
        Customer Class: 
        <select name="customer_class" required>
            <option value="premium">Premium</option>
            <option value="gold">Gold</option>
            <option value="standard">Standard</option>
        </select><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>