<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <link href="static/styling.css" rel="stylesheet">
</head>
<body>
<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create connection
    $conn = new mysqli($servername, $serverusername, $serverpassword, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // collect value of input field
    $name = $conn->real_escape_string($_POST['name']);
    $surname = $conn->real_escape_string($_POST['surname']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string(password_hash($_POST['password'], PASSWORD_DEFAULT));


    $sql = "INSERT INTO users (username, surname, name, password)
    VALUES ('$username', '$surname', '$name', '$password')";

    if ($conn->query($sql) === TRUE) {
        header("Location: /home.php");
    } else {
        echo '<script>';
        echo 'alert("Could not create account")';
        echo '</script>';
    }
    $conn->close();
}

?>

<header>COVID-19 Contact Tracing</header>

<form class="centered" method="post" action="registration.php" style="width: 45%">
    <input type="text" class="loginelements" name="name" placeholder="Name" required>
    <input type="text" class="loginelements" name="surname" placeholder="Surname" required>
    <input type="text" class="loginelements" name="username" placeholder="Username" required>
    <input type="password" class="loginelements" name="password" placeholder="Password" pattern=".{8,}"
           style="margin-bottom: 40px" required>
    <input type="submit" value="Register">
</form>


</body>
</html>