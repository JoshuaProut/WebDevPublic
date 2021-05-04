<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="static/styling.css">
    <style>

    </style>
</head>
<body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "config.php";

    // Create connection
    $conn = new mysqli($servername, $serverusername, $serverpassword, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

// collect value of input field
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);


    $sql = "SELECT username, password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row["password"]) == true) {
                session_start();
                $_SESSION['username'] = $row['username'];
                header('Location: /home.php');
            } else {
                echo '<script>';
                echo 'alert("Password not correct")';
                echo '</script>';
            }
        }
    } else {
        echo '<script>';
        echo 'alert("Username not recognised")';
        echo '</script>';
    }
    $conn->close();
}
?>

<header>COVID-19 Contact Tracing</header>

<script>
    function clearValues() {
        document.getElementById("usernameInput").innerText = "";
        document.getElementById("passwordInput").innerText = "";
    }
</script>


<div class="maincontent, centered" style="margin: auto; width: 20%">
    <form method="post" action="/login.php">
        <input type="text" class="loginelements" style="width: 100%" name="username" id="usernameInput"
               placeholder="Username" required><br>
        <input type="password" class="loginelements" style="width: 100%" name="password" id="passwordInput"
               placeholder="Password" required><br>
        <input type="submit" class="loginelements"
               style="width: 45%; margin-right: 5px; float: left; background-color: white">
        <button name="cancel" class="loginelements"
                style="width: 45%; margin-left: 5px; float: right; background-color: white" onclick="clearValues()">
            Cancel
        </button>
    </form>
    <br>
    <form action="/registration.php" method="get">
        <input type="submit" value="Registration" style="width: 300px; background-color: white"/>
    </form>
</div>

</body>
</html>