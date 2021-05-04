<?php
session_start();
//if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Connects to DB

include "config.php";

// Create connection
$conn = new mysqli($servername, $serverusername, $serverpassword, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Gets all user visits from database
$username = $_SESSION["username"];
$sql = "SELECT * FROM visits WHERE username = '$username'";
$result = $conn->query($sql);

// Gets the user infection window in days
if (isset($_COOKIE["window"])) {
    $window = $_COOKIE["window"] * 7;
} else {
    $window = 7;
}

// Gets user infection radius
if (isset($_COOKIE["distance"])) {
    $euclidDistance = $_COOKIE["distance"];
    // This distance is the radius of the infection to be considered
    $actualDistance = sqrt(($euclidDistance * $euclidDistance) / 2);

} else {
    $actualDistance = 5;
}

// For each visit, selects infections that match the parameters and adds json encoding to array
$visits = [];
$infections = [];

//class to store variables for json encoding
class infection
{
    public $x;
    public $y;
}

while ($row = $result->fetch_assoc()) {

    /* Signifies if the visit should be added to the map, starts as false, if any infections are linked to the visit,
    it is set to true*/
    $addtomap = false;


    // Calculates date boundaries
    $date = $row["date"];
    $earlierdate = strtotime($date) - (60 * 60 * 24 * $window);
    $earlierdate = date('Y-m-d', $earlierdate);
    $laterdate = strtotime($date) + (60 * 60 * 24 * $window);
    $laterdate = date('Y-m-d', $laterdate);

    // Calculates coordinate boundaries
    $upperx = $row["x"] + $actualDistance;
    $lowerx = $row["x"] - $actualDistance;
    $uppery = $row["y"] + $actualDistance;
    $lowery = $row["y"] - $actualDistance;

    // Select all infection events within the date and coordinate boundaries
    $infectionSql = "SELECT x,y FROM infections WHERE date >= '$earlierdate' AND date <='$laterdate' AND x>= $lowerx AND x<= $upperx AND y>= $lowery AND y<= $uppery";

    $infectionresult = $conn->query($infectionSql);
    while ($infectionrow = $infectionresult->fetch_assoc()) {
        $infection = new infection();
        $infection->x = $infectionrow["x"];
        $infection->y = $infectionrow["y"];
        array_push($infections, json_encode($infection));
        $addtomap = true;
    }

    if ($addtomap === true) {
        $visit = new infection();
        $visit-> x = $row["x"];
        $visit -> y = $row["y"];
        array_push($visits, json_encode($visit));
    }
}
echo "{\"infections\":". "[" . implode(",", $infections) . "] , \"visits\":" . "[" . implode(",", $visits) . "]}";
?>

