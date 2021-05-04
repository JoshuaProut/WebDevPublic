<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Report</title>
    <link rel="stylesheet" href="static/styling.css">
</head>

<body>
<?php
session_start();
if (empty($_SESSION["username"]) == true) {
    header("Location: /login.php");
}
?>

<?php

class Location
{
    public $locx;
    public $locy;
    public $locdate;
    public $loctime;
    public $locduration;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "config.php";

// Create connection
    $conn = new mysqli($servername, $serverusername, $serverpassword, $dbname);
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get variables
    $date = $conn->real_escape_string($_POST["date"]);
    $time = $conn->real_escape_string($_POST["time"]);

    // Gets all user visits
    $username = $_SESSION["username"];
    $sql = "SELECT * FROM visits WHERE username = '$username'";
    $result = $conn->query($sql);

    // For each visit
    while ($row = $result->fetch_assoc()) {

        $duration = $row["duration"];
        $x = $row["x"];
        $y = $row["y"];

        // Adds to database
        $sqlinsert = "INSERT INTO infections (date, time, duration, x, y)
VALUES ('$date', '$time', '$duration', '$x', '$y')";
    }

    if ($conn->query($sqlinsert) === TRUE) {
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();

    // Sends to webservice
    $postRequest = curl_init();

    curl_setopt($postRequest, CURLOPT_URL, "http://ml-lab-7b3a1aae-e63e-46ec-90c4-4e430b434198.ukwest.cloudapp.azure.com:60999/report");
    curl_setopt($postRequest, CURLOPT_POST, 1);


    $location = new Location;
    $location-> locx = $x;
    $location-> locy = $y;
    $location-> locdate = $date;
    $location-> loctime = $time;
    $location-> locduration = $duration;

    $jsondata = json_encode($location);
        curl_setopt($postRequest, CURLOPT_POSTFIELDS,
            $jsondata);
    curl_setopt($postRequest, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($postRequest);
    curl_close($postRequest);
}


?>

<header>COVID-19 Contact Tracing</header>
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
            <td class="menucurrentpage"><a href="reportcontact.php">Report</a></td>
        </tr>
        <tr>
            <td><a href="settings.php">Settings</a></td>
        </tr>
        <tr>
            <td class="logout"><a href="logout.php">Logout</a></td>
        </tr>
    </table>
</div>

<div class="centered" style="padding-left: 20px" align="center">
    <h1>Report an Infection</h1>
    <hr>
    <p>Please report the date and time when you were tested positive for COVID-19</p>

    <div class="centered" style="width: 40%;" align="center">
        <form action="reportcontact.php" method="post">
            <input type="date" name="date" align="center" required><br>
            <input type="time" name="time" align=center required><br>
            <input type="submit" style="width: 100px; float: left">
            <input type="button" name="Cancel" value="Cancel" style="width: 100px; float: right">
        </form>
    </div>
</div>
</body>
</html>