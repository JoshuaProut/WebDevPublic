<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Overview</title>
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
<div class="navbar">
    <table class="menutable">
        <tr>
            <td id="home"><a href="home.php">Home</a></td>
        </tr>
        <tr>
            <td class="menucurrentpage"><a href="overview.php">Overview</a></td>
        </tr>
        <tr>
            <td><a href="addvisit.php">Add Visit</a></td>
        </tr>
        <tr>
            <td><a href="reportcontact.php">Report</a></td>
        </tr>
        <tr>
            <td><a href="settings.php">Settings</a></td>
        </tr>
        <tr>
            <td class="logout"><a href="logout.php">Logout</a></td>
        </tr>
    </table>
</div>

<div class="maincontent">

    <?php
    include "config.php";

    // Create connection
    $conn = new mysqli($servername, $serverusername, $serverpassword, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_SESSION["username"];
    $sql = "SELECT * FROM visits WHERE username = '$username'";
    $result = $conn->query($sql);
    ?>

    <?php

    // Deletes selected visit from the database
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $visitid = $_POST["visitid"];
        $sql = "DELETE FROM visits WHERE visitid = '$visitid'";
        $conn->query($sql);
    }
    ?>

    <table id="visitTable" style="margin: auto; width: 80%; margin-top: 50px; font-size: large;">
        <tr>
            <th class='overview'>Date</th>
            <th class='overview'>Time</th>
            <th class='overview'>Duration</th>
            <th class='overview'>X</th>
            <th class='overview'>Y</th>
        </tr>
        <?php
        // Writes each visit into the table
        if ($result->num_rows > 0) {
            //sets row counter
            $tableRowNumber = 1;

            while ($row = $result->fetch_assoc()) {
                echo "<tr>" .
                    "<td class='overview'>" . $row["date"] . "</td>" .
                    "<td class='overview'>" . $row["time"] . "</td>" .
                    "<td class='overview'>" . $row["duration"] . "</td>" .
                    "<td class='overview'>" . $row["x"] . "</td>" .
                    "<td class='overview'>" . $row["y"] . "</td>" .
                    "<td><img src='static/cross.png' height='30' width='30' onclick='removeVisit($row[visitid], $tableRowNumber)'></td>"
                    . "</tr>";

                // Increments row number
                $tableRowNumber++;
            }
        }
        ?>
    </table>

    <script>
        /**
         * Removes the a visit from the database and page.
         *
         * An HTTP post request is sent containing the visitid to be removed. The row is then removed from the document
         * using the sequntial row number
         *
         * @param visitid the primary key value for the visit in the visits table to be removed
         * @param rownumber the sequential row number in the visit table
         */
        function removeVisit(visitid, rownumber) {
            var xhttp = new XMLHttpRequest();
            xhttp.open("POST", "overview.php", false);
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.send("visitid="+visitid);

            //Removes visit from table
            document.getElementById("visitTable").deleteRow(rownumber);
        }
    </script>
</div>
</body>


</html>