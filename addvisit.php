<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Visit</title>
    <link href="static/styling.css" rel="stylesheet">
</head>
<body>
<header>COVID-19 Contact Tracing</header>

<?php
session_start();
if (empty($_SESSION["username"]) == true) {
    header("Location: /login.php");
}
?>

<div class="navbar">
    <table class="menutable">
        <tr>
            <td id="home" ><a href="home.php">Home</a></td>
        </tr>
        <tr>
            <td><a href="overview.php">Overview</a></td>
        </tr>
        <tr>
            <td class="menucurrentpage"><a href="addvisit.php" >Add Visit</a></td>
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
    <h1>Add a new Visit</h1>
    <hr>
    <div style="float: left; width: 30%">
        <form action="addvisitsubmit.php" method="post">
            <input type="date" name="date" required>
            <input type="time" name="time" required>
            <input type="text" name="duration" placeholder="Duration" required>
            <input type="text" name="x" id="xform" hidden required>
            <input type="text" name="y" id="yform" hidden required>
            <input type="submit" value="Add" style="margin-top: 100px">
        </form>
        <button onclick="clearVisitValues()">Cancel</button>
        <script>
            function clearVisitValues (){
                document.getElementById()
            }
        </script>
    </div>

    <script>
        window.onload = function () {
            var canvas = document.getElementById("myCanvas");
            var ctx = canvas.getContext("2d");
            ctx.drawImage(document.getElementById("Exeter"), 0, 0);
        };
    </script>

    <div style="float: left; width: 50%;">
        <canvas width="500" height="500" id="myCanvas">
        </canvas>

        <script>

            function placePointer(x, y) {
                var canvas = document.getElementById("myCanvas");
                var ctx = canvas.getContext("2d");
                ctx.drawImage(document.getElementById("Pointer"), x - 15, y - 30);
            }

            function getMousePosition(canvas, event) {
                let map = canvas.getBoundingClientRect();
                //console.log(map.bottom);
                //console.log(map.left);
                console.log(event.clientX);
                console.log(event.clientY);

                let x = event.clientX - map.left;
                let y = event.clientY - map.top;
                document.getElementById("xform").value = Math.ceil(x / 5);
                document.getElementById("yform").value = Math.ceil(y / 5);
                placePointer(x, y);
            }

            let canvasElem = document.querySelector("canvas");

            canvasElem.addEventListener("mousedown", function (e) {
                getMousePosition(canvasElem, e);
            });
        </script>
    </div>
</div>

<img src="static/exeter500.jpeg" width="500" height="500" alt="Exeter" id="Exeter" hidden>
<img src="static/marker_black_small.png" alt="BlackMarker" id="Pointer" hidden>
</body>
</html>