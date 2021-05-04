<?php
session_start();
if ($_SESSION["username"] == "Admin") {
// set url
    echo "working";
    $cURLConnection = curl_init();

    curl_setopt($cURLConnection, CURLOPT_URL, "http://ml-lab-7b3a1aae-e63e-46ec-90c4-4e430b434198.ukwest.cloudapp.azure.com:60999/infections?ts=1");
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

    $text = curl_exec($cURLConnection);
    curl_close($cURLConnection);

    $infections = json_decode($text, true);

    echo $text;

    include "config.php";

// Create connection
    $conn = new mysqli($servername, $serverusername, $serverpassword, $dbname);
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);

    }

    foreach ($infections as $infection) {

        $date = $infection["date"];
        $time = $infection["time"];
        $duration = $infection["duration"];

        // Scales values to match those in database
        $x = $infection["x"] / 38.38;
        $y = $infection["y"] / 38.38;

        $sqlinsert = "INSERT INTO infections (date, time, duration, x, y)
VALUES ('$date', '$time', '$duration', '$x', '$y')";

    }
    if ($conn->query($sqlinsert) === TRUE) {
        echo "Succesfully retrieved data";
    } else {
        echo "Error: " . $sqlinsert . "<br>" . $conn->error;
    }
    $conn->close();

}
else {
    header("Location: home.php");
}


?>
