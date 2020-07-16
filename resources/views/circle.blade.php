@extends('layouts.app')

@section('content')
<div class="container justify-content-center">
    <div class="row">
        <div class="col-md-1">
            <a id="download" href="#"  onclick="saveit()" download>download</a>

        </div>
    </div>
    <div class="row ">
        <div class="col-lg-6">
            <canvas id="can" width="500" height="500"></canvas>
            <img id="image" style="display: none;"/>
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
    var entries = Object.entries(values);

    var myTotal = 0;
    var myColor = ['#4CAF50', '#00BCD4', '#E91E63', '#FFC107', '#9E9E9E', '#CDDC39', '#18FFFF', '#F44336', '#6D4C41','red', 'green', 'blue','gray','yellow','black','cyan','pink','purple','brown']; // Colors of each slice


    var arcs =[];
    function draw() {
        arcs = [];
        myTotal = 0;

        // calculate the total value we have
        entries.forEach(function (val,idx) {

            myTotal+=val[1][1]/1 ;

        });
        // get the <ul> to put <li> in it that have the name and input to change the color
        document.getElementById("dvLegend").innerHTML = "";
        var beginAngle = 0;
        var endAngle = 0;
        entries.forEach(function (val,idx) {
            ctx.fillStyle = myColor[idx]; // choosing color
            ctx.beginPath(); // start drawing
            ctx.moveTo(canvas.width / 2, canvas.height / 2); // move the cursor to start position
            // Arc Parameters: x, y, radius, startingAngle (radians), endingAngle (radians), antiClockwise (boolean)
            ctx.arc(canvas.width / 2, canvas.height / 2, canvas.height / 2, lastend, lastend + (Math.PI * 2 * (val[1][1] / myTotal)), false);
            ctx.lineTo(canvas.width / 2, canvas.height / 2); // رسم القطاع الدائري و اغلاقه
            ctx.fill();
            // store the value of each circle start angle and end angle to use it again in arcs array
            arcs.push([lastend, lastend + (Math.PI * 2 * (val[1][1] / myTotal))]);
            var x = document.createElement("LI"); // create li element to put it in the ul
            x.id = idx; // assign id value
            var t = document.createTextNode(val[1][0]); // create text inside the li
            var tt = document.createElement("input"); // create change color input
            tt.style.float = "right"; // put the input on the right side
            var emp = document.createTextNode(" ");
            tt.type = "color"; // make the type of input color
            // put the elements inside each other
            x.appendChild(t);
            x.appendChild(emp);
            x.appendChild(tt);
            x.style.background = myColor[idx]; // give a background color to the li same as the color of its arc
            x.className = "list-group-item";

            // put the value in the middle of the arc and this is the equation to make that
            beginAngle = endAngle; //begin angle
            endAngle = endAngle + ((Math.PI * 2) * (val[1][1] / myTotal)); //end angle
            var pieRadius = Math.min(canvas.width / 2, canvas.height / 2);
            var labelX = canvas.width / 2 + (pieRadius / 2) * Math.cos(beginAngle + (endAngle - beginAngle) / 2);
            var labelY = canvas.height / 2 + (pieRadius / 2) * Math.sin(beginAngle + (endAngle - beginAngle) / 2);
            ctx.fillStyle = "white";
            ctx.font = "bold 10px Arial";
            ctx.fillText(""+ val[1][1], labelX, labelY);


            document.getElementById("dvLegend").append(x);

            // when mouse move on the li element
            x.onmouseover = function () {
                hover(this.id); // call hover function that will draw again
                this.style.fontSize = "20px"; // make the font bigger
                this.style.cursor = "pointer";
            };

            // when moving mouse out of the li
            x.onmouseout = function () {
                //hover(this.id);
                this.style.fontSize = "18px"; // just make the font as default
            };

            tt.onchange = function () {
                edit(idx,this.value); // when the color change call edit to change it on circle
            };

            // move cursor to the end of arc to draw the next arc
            lastend += Math.PI * 2 * (val[1][1] / myTotal);
        });
    }

    function edit(idx,col) {

        myColor[idx] = col; // change the color as requested
        reset(); // clear canvas
        draw(); // draw again with the new color
    }
    function reset(){
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    }

    function hover(id) {
        // this function to draw again when mouse over li element
        // and we use arcs array to draw
        var i = 0, r;
        var beginAngle = 0;
        var endAngle = 0;
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        var j=0;
        while (r = arcs[i]) {
            ctx.beginPath();
            ctx.moveTo(canvas.width / 2, canvas.height / 2);
            ctx.arc(canvas.width / 2, canvas.height / 2, canvas.height / 2, arcs[i][0], arcs[i][1], false);
            ctx.lineTo(canvas.width / 2, canvas.height / 2);
            ctx.fillStyle = myColor[j];

            // the only difference from draw function
            // we have the id of li element the mouse over it
            // we make the arc bigger if we are drawing it and its id equal to the index
            if(id == i) {
                ctx.lineWidth   = 8;
                ctx.strokeStyle = myColor[j];
                ctx.stroke();
            }
            ctx.fill();

            beginAngle = arcs[i][0]; //begin angle
            endAngle = arcs[i][1]; //end angle
            var pieRadius = Math.min(canvas.width / 2, canvas.height / 2);
            var labelX = canvas.width / 2 + (pieRadius / 2) * Math.cos(beginAngle + (endAngle - beginAngle) / 2);
            var labelY = canvas.height / 2 + (pieRadius / 2) * Math.sin(beginAngle + (endAngle - beginAngle) / 2);
            ctx.fillStyle = "white";
            ctx.font = "bold 10px Arial";
            ctx.fillText(""+ values[i][1], labelX, labelY);
            j++;
            i++;
        }

    }


    canvas.onmousemove = function (e) {
        // when mouse move on the canvas

        var rect = this.getBoundingClientRect(),
            x = e.clientX - rect.left,
            y = e.clientY - rect.top,
            i = 0, r;
        var beginAngle = 0;
        var endAngle = 0;

        ctx.clearRect(0, 0, canvas.width, canvas.height);


        var j=0;
        while (r = arcs[i]) {
            ctx.beginPath();
            ctx.moveTo(canvas.width / 2, canvas.height / 2);
            ctx.arc(canvas.width / 2, canvas.height / 2, canvas.height / 2, arcs[i][0], arcs[i][1], false);
            ctx.lineTo(canvas.width / 2, canvas.height / 2);
            //alert(arcs[i][0]+" "+x+" "+arcs[i][1]+" "+y);
            ctx.fillStyle = myColor[j];

            // the only difference from draw function
            // we have the point x and y
            // we make the arc bigger if we are drawing it and the (x,y) point inside the arc
            if(ctx.isPointInPath(x, y)) {
                document.getElementById(i).style.fontSize = "20px";
                document.getElementById("can").style.cursor = "pointer";
                ctx.lineWidth   = 8;
                ctx.strokeStyle = myColor[j];
                ctx.stroke();
            }
            ctx.fill();

            beginAngle = arcs[i][0]; //begin angle
            endAngle = arcs[i][1]; //end angle
            var pieRadius = Math.min(canvas.width / 2, canvas.height / 2);
            var labelX = canvas.width / 2 + (pieRadius / 2) * Math.cos(beginAngle + (endAngle - beginAngle) / 2);
            var labelY = canvas.height / 2 + (pieRadius / 2) * Math.sin(beginAngle + (endAngle - beginAngle) / 2);
            ctx.fillStyle = "white";
            ctx.font = "bold 10px Arial";
            ctx.fillText(""+ values[i][1], labelX, labelY);
            j++;
            i++;
        }

    };

    // when mouse out of canvas resize the font to its default value
    canvas.onmouseout = function (e) {
        for(var i=0;i<entries.length;i++) {
            document.getElementById(i).style.fontSize = "18px";
        }
    };

    function saveit() {

        var dataUrl = canvas.toDataURL();
        document.getElementById("image").src = dataUrl;
        document.getElementById("download").href = dataUrl;
    }

    
    draw();

</script>

<script>
    $(document).ready(function(){
        setInterval(function(){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:'/circle',
                type:'GET',
                dataType:'json',
                success:function(response){
                    if(response.all.length>0){
                        values = JSON.parse(response.all);
                        entries = Object.entries(values);
                        //alert(values);
                        reset();
                        draw();
                    }
                },error:function(err){

                }
            })
        }, 3000);
    });
</script>
@endsection