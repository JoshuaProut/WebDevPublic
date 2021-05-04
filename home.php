<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link href="static/styling.css" rel="stylesheet">
</head>
<body>
<img src="static/exeter500.jpeg" id="Exeter" alt="Exeter" hidden>
<img src="static/marker_red.png" id="redPointer" alt="RedPointer" onclick="test" hidden>
<img src="static/marker_black.png" id="blackPointer" alt="BlackPointer" onclick="test" hidden>

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
            <td id="home" class="menucurrentpage"><a href="home.php">Home</a></td>
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
            <td><a href="settings.php">Settings</a></td>
        </tr>
        <tr>
            <td class="logout"><a href="logout.php">Logout</a></td>
        </tr>
    </table>
</div>

<div class="maincontent">
    <h1>Status</h1>
    <hr>
    <div style="float: left; width:15%; margin-left: 2%; margin-right: 2%;">
        <p>Hi <?php echo $_SESSION['username'] ?> you might have had a connection to an infected
            person at the location shown in red</p><br>
        <p>Click on the marker to see details about the infection</p>
    </div>

    <div style="float:left;">
    <canvas width="500" height="500" id="Canvas">
        <script>
            /**
             *  Draws city map onto the canvas
             */
            window.onload = function () {
                var canvas = document.getElementById("Canvas");
                var ctx = canvas.getContext("2d");
                ctx.drawImage(document.getElementById("Exeter"), 0, 0);
                getData();
            };

            /**
             * Places pointer on map
             * @param x coordinate between 0 and 100
             * @param y coordinate between 0 and 100
             * @param redpointer true if a redpointer is to be placed
             */
            function placePointer(x,y, redpointer) {
                var canvas = document.getElementById("Canvas");
                var ctx = canvas.getContext("2d");
                if (redpointer === true) {
                    ctx.drawImage(document.getElementById("redPointer"), x * 5, y * 5, 30, 30);
                } else {
                    ctx.drawImage(document.getElementById("blackPointer"), x * 5, y * 5, 30, 30);
                }
            }
        </script>
    </canvas>
    </div>
</div>

<script>
    /**
     * Gets JSON object containing a list of infection event coordinates and visit coordinates, calls function to place
     * on the map.
     */
    function getData() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "infections.php", false);
        xmlhttp.send();
        console.log(xmlhttp.responseText);
        var data = JSON.parse(xmlhttp.responseText);
        var infections = data.infections;
        var visits = data.visits;
        for (i=0;i<infections.length;i++) {
            placePointer(infections[i].x, infections[i].y, true);
        }
        for (i=0;i<visits.length;i++) {
            placePointer(visits[i].x, visits[i].y, false);
        }

    }
</script>
</body>
</html>