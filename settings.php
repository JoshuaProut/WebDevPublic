<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Settings</title>
    <link rel="stylesheet" href="static/styling.css">
</head>
<body>

<?php
session_start();
if (empty($_SESSION["username"]) == true) {
    header("Location: /login.php");
}
?>

<header>COVID-19 Contact Tracing</header>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Gets variables from form
    $window = $_POST["contactwindow"];
    $distance = floatval(($_POST["distance"]));

    // checks values are in range, then writes to cookie
    if ($distance > 0 and $distance <= 500) {
        setcookie("window", $window, time() + 60 * 60 * 24 * 365, "/");
        setcookie("distance", $distance, time() + 60 * 60 * 24 * 365, "/");
    }
}
?>
<div class="navbar">
    <table class="menutable">
        <tr>
            <td id="home"><a href="home.php">Home</a></td>
        </tr>
        <tr>
            <td><a href="overview.php">Overview</a></td>
        </tr>
        <tr>
            <td><a href="addvisit.php">Add Visit</a></td>
        </tr>
        <tr>
            <td><a href="reportcontact.php">Report</a></td>
        </tr>
        <tr>
            <td class="menucurrentpage"><a href="settings.php">Settings</a></td>
        </tr>
        <tr>
            <td class="logout"><a href="logout.php">Logout</a></td>
        </tr>
    </table>
</div>

<div class="maincontent, centered">
    <h1>Alert Settings</h1>
    <hr>
    <p>Here you may change the alert distance and the time span for which the contact tracing will be performed</p>
</div>
<div class="centered" style="width: 30%">
    <form action="settings.php" method="post">
        <label for="contactwindow" style="padding-right: 5px">Window</label>
        <select id="contactwindow" name="contactwindow" style="width: 70%" class="loginelements" required>
            <option label="Select an option"></option>
            <option value="1">1 Week</option>
            <option value="2">2 Weeks</option>
            <option value="3">3 Weeks</option>
            <option value="4">4 Weeks</option>
        </select>
        <br>
        <label for="distance">Distance</label>
        <input type="text" name="distance" id="distance" style="width: 70%" required><br>
        <input type="submit" value="Set Option" style="float: left; width: 50%" class="loginelements">
    </form>
    <button style="float: right; width: 50%">Cancel</button>
</div>

</body>
</html>