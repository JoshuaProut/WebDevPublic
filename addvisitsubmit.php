<?php

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Create connection
    $conn = new mysqli($servername, $serverusername, $serverpassword, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    session_start();
    $username = $_SESSION["username"];
    $date = $conn -> real_escape_string($_POST["date"]);
    $time = $conn -> real_escape_string($_POST["time"]);
    $duration = $conn -> real_escape_string($_POST["duration"]);
    $x = $conn -> real_escape_string($_POST["x"]);
    $y = $conn -> real_escape_string($_POST["y"]);


    $sql = "INSERT INTO visits (username, date, time, duration, x, y)
    VALUES ('$username', '$date', '$time', '$duration','$x','$y')";

    if ($conn->query($sql) === TRUE) {
        header("Location: /addvisit.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();


}
