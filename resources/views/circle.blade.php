@extends('layouts.app')

@section('content')
<div class="container justify-content-center">
    <div class="row ">
        <div class="col-lg-6">
            <canvas id="can" width="500" height="500"></canvas>
        </div>
        <div class="col-lg-3">
            <ul id="dvLegend"></ul>
        </div>
    </div>
</div>


<br/>
<br/>

<script>
    var canvas = document.getElementById("can");
    var ctx = canvas.getContext("2d");
    var lastend = 0;
    var data = [];
    var values = {!! $all !!};
    const entries = Object.entries(values);

    var myTotal = 0;
    var myColor = ['#4CAF50', '#00BCD4', '#E91E63', '#FFC107', '#9E9E9E', '#CDDC39', '#18FFFF', '#F44336', '#6D4C41','red', 'green', 'blue','gray','yellow','black','cyan','pink','purple','brown']; // Colors of each slice

    entries.forEach(function (val,idx) {

       myTotal+=val[1][1]/1 ;

    });
    var arcs =[];
    entries.forEach(function (val,idx) {
        ctx.fillStyle = myColor[idx%myColor.length];
        ctx.beginPath();
        ctx.moveTo(canvas.width / 2, canvas.height / 2);
        // Arc Parameters: x, y, radius, startingAngle (radians), endingAngle (radians), antiClockwise (boolean)
        ctx.arc(canvas.width / 2, canvas.height / 2, canvas.height / 2, lastend, lastend + (Math.PI * 2 * (val[1][1] / myTotal)), false);
        ctx.lineTo(canvas.width / 2, canvas.height / 2);
        ctx.fill();
        arcs.push([lastend, lastend + (Math.PI * 2 * (val[1][1] / myTotal))]);
        var x = document.createElement("LI");
        x.id = idx;
        var t = document.createTextNode(val[1][0]+" "+val[1][1]);
        x.appendChild(t);
        x.style.background = myColor[idx%myColor.length];
        x.className = "list-group-item";

        document.getElementById("dvLegend").append(x);

        x.onmouseover = function () {
            hover(this.id);
            this.style.fontSize = "20px";
            this.style.cursor = "pointer";
        };
        x.onmouseout = function () {
            //hover(this.id);
            this.style.fontSize = "18px";
        };


        lastend += Math.PI * 2 * (val[1][1] / myTotal);
    });

    function hover(id) {

        var i = 0, r;
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        var j=0;
        while (r = arcs[i]) {
            ctx.beginPath();
            ctx.moveTo(canvas.width / 2, canvas.height / 2);
            ctx.arc(canvas.width / 2, canvas.height / 2, canvas.height / 2, arcs[i][0], arcs[i][1], false);
            ctx.lineTo(canvas.width / 2, canvas.height / 2);
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
                document.getElementById(i).style.fontSize = "20px";

                ctx.lineWidth   = 8;
                ctx.strokeStyle = myColor[j];
                ctx.stroke();
            }
            ctx.fill();
            j++;
            i++;
        }

    };

    canvas.onmouseout = function (e) {
        for(var i=0;i<entries.length;i++) {
            document.getElementById(i).style.fontSize = "18px";
        }
    }



</script>
@endsection