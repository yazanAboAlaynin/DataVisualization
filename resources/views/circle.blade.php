<html>
<head>

</head>
<body >


<canvas id="can" width="200" height="200" ></canvas>
<br/>
<br/>
<ul id="dvLegend"></ul>
<script>
    var canvas = document.getElementById("can");
    var ctx = canvas.getContext("2d");
    var lastend = 0;
    var data = [200, 60, 15,200, 60, 15,200, 60, 15,200];
    var values = {!! $all !!};

    var myTotal = 0;
    var myColor = ['#4CAF50', '#00BCD4', '#E91E63', '#FFC107', '#9E9E9E', '#CDDC39', '#18FFFF', '#F44336', '#6D4C41','red', 'green', 'blue','gray','yellow','black','cyan','pink','purple','brown']; // Colors of each slice

    for (var e = 0; e < data.length; e++) {
        myTotal += data[e];
    }
    var arcs =[];
    for (var i = 0; i < data.length; i++) {
        ctx.fillStyle = myColor[i%myColor.length];
        ctx.beginPath();
        ctx.moveTo(canvas.width / 2, canvas.height / 2);
        // Arc Parameters: x, y, radius, startingAngle (radians), endingAngle (radians), antiClockwise (boolean)
        ctx.arc(canvas.width / 2, canvas.height / 2, canvas.height / 2, lastend, lastend + (Math.PI * 2 * (data[i] / myTotal)), false);
        ctx.lineTo(canvas.width / 2, canvas.height / 2);
        ctx.fill();
        arcs.push([lastend, lastend + (Math.PI * 2 * (data[i] / myTotal))]);
        var x = document.createElement("LI");
        x.id = i;
        var t = document.createTextNode("color "+myColor[i]+" is for "+data[i]);
        x.appendChild(t);
        x.style.color = myColor[i];
        document.getElementById("dvLegend").append(x);
        x.onmouseover = function () {
          hover(this.id);
        };

        lastend += Math.PI * 2 * (data[i] / myTotal);
    }


    function hover(id) {

           var i = 0, r;
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        var j=0;
        while (r = arcs[i]) {
            ctx.beginPath();
            ctx.moveTo(canvas.width / 2, canvas.height / 2);
            ctx.arc(canvas.width / 2, canvas.height / 2, canvas.height / 2, arcs[i][0], arcs[i][1], false);
            ctx.lineTo(canvas.width / 2, canvas.height / 2);
            //alert(arcs[i][0]+" "+x+" "+arcs[i][1]+" "+y);
            ctx.fillStyle = myColor[j];


            if(id == i) {
                ctx.lineWidth   = 8;
                ctx.strokeStyle = myColor[j];
                ctx.stroke();
            }
            ctx.fill();
            j++;
            i++;
        }

    }

    canvas.onmousemove = function (e) {


        var rect = this.getBoundingClientRect(),
            x = e.clientX - rect.left,
            y = e.clientY - rect.top,
            i = 0, r;

        ctx.clearRect(0, 0, canvas.width, canvas.height);


        var j=0;
        while (r = arcs[i]) {
            ctx.beginPath();
            ctx.moveTo(canvas.width / 2, canvas.height / 2);
            ctx.arc(canvas.width / 2, canvas.height / 2, canvas.height / 2, arcs[i][0], arcs[i][1], false);
            ctx.lineTo(canvas.width / 2, canvas.height / 2);
            //alert(arcs[i][0]+" "+x+" "+arcs[i][1]+" "+y);
            ctx.fillStyle = myColor[j];


            if(ctx.isPointInPath(x, y)) {
                ctx.lineWidth   = 8;
                ctx.strokeStyle = myColor[j];
                ctx.stroke();
            }
            ctx.fill();
            j++;
            i++;
        }

    };


</script>
</body>
</html>