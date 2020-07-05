<html>
<head>

</head>
<body align="center">

<input type="button" value="submit" name="submit" onclick="draw()">
<input type="button" value="Clear" name="Clear" onclick="reset()"><br><br>
<canvas id="can" width="200" height="200" ></canvas>
<script>

    var canvas = document.getElementById("can");
    var ctx = canvas.getContext("2d");
    var lastend = 0;
    var data = [200, 60, 15,200, 60, 15,200, 60, 15,200, 60, 15,200, 60, 15,200, 60, 15]; // If you add more data values make sure you add more colors
    var myTotal = 0; // Automatically calculated so don't touch
    var myColor = ['red', 'green', 'blue','gray','yellow','black','cyan','pink','purple','brown']; // Colors of each slice

    for (var e = 0; e < data.length; e++) {
        myTotal += data[e];
    }

    for (var i = 0; i < data.length; i++) {
        ctx.fillStyle = myColor[i%myColor.length];
        ctx.beginPath();
        ctx.moveTo(canvas.width / 2, canvas.height / 2);
        // Arc Parameters: x, y, radius, startingAngle (radians), endingAngle (radians), antiClockwise (boolean)
        ctx.arc(canvas.width / 2, canvas.height / 2, canvas.height / 2, lastend, lastend + (Math.PI * 2 * (data[i] / myTotal)), false);

        ctx.lineTo(canvas.width / 2, canvas.height / 2);

        ctx.fill();
        lastend += Math.PI * 2 * (data[i] / myTotal);
    }
</script>
</body>
</html>