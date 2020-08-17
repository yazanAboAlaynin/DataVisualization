@extends('layouts.app')

@section('content')

    <div class="container justify-content-center">
        <div class="row pb-3">

            <div class="col-md-6">
                <label for="favcolor">Select your favorite line color:</label>
                <input class="" type="color" value="Clear" name="Clear" onchange="edit(this.value)">
            </div>
            <div class="col-md-6">
                <a id="download" href="#"  onclick="saveit()" download>download</a>
            </div>
        </div>


        <div class="row ">
            <div class="col-lg-6">
                <canvas id="coordinate" width="1000" height="500" style="border:1px solid black">
                </canvas>
                <img id="image" style="display: none;"/>
            </div>
            <div class="col-lg-3">
                <ul id="dvLegend"></ul>
            </div>
        </div>
    </div>


<script>

    var Ccanvas = document.getElementById('myCanvas');
    var color = "#042b76";


    var Cctx = Ccanvas.getContext('2d');
    var values = {!! $all !!};


    var entries = Object.entries(values);


    function drawGrids() {
        // draw the background grids
        var xGrid = 10;
        var yGrid = 10;
        var cellSize = 10;
        Cctx.beginPath();

        // draw until we xGrid smaller than canvas height
        while(xGrid < Ccanvas.height){
            Cctx.moveTo(0,xGrid); // move to the start position (0,xGrid) on the y axis
            Cctx.lineTo(Ccanvas.width,xGrid); // draw line to the end  of the canvas
            xGrid+=cellSize;
        }

        // draw until we yGrid smaller than canvas width
        while(yGrid < Ccanvas.width){
            Cctx.moveTo(yGrid,0);// move to the start position (yGrid,0) on the x axis
            Cctx.lineTo(yGrid,Ccanvas.height); // draw line to the end  of the canvas
            yGrid+=cellSize;
        }
        Cctx.strokeStyle = "gray";
        Cctx.stroke();
    }

    function blocks(count){
        return count*10;
    }

    function drawAxis(){
        // draw the primary axis
        var yPlot = 40;
        var pop = 0;

        Cctx.beginPath();
        Cctx.strokeStyle = "black"; //give it color black
        Cctx.moveTo(blocks(5),blocks(5)); // move 5 blocks on the x and 5 on the y
        Cctx.lineTo(blocks(5),blocks(40)); // Y axis: draw line to position (5 blocks on x, 40 block on y)
        Cctx.lineTo(blocks(80),blocks(40)); // X axis: draw line to position (80 blocks , 40 blocks)

        Cctx.moveTo(blocks(5),blocks(40)); // move to position ( 5 blocks, 40 blocks)

        // draw the numbers on the Y axis
        for(var i=1;i<=10;i++){
            // pop is the number we want to draw it start with 0 and increase 500 every time
            Cctx.strokeText(pop,blocks(2),blocks(yPlot)); // draw text (pop) in position (2 block,yPlot)
            yPlot-=5;
            pop+=500;
        }

        Cctx.stroke();

    }

    function drawChart() {

        // draw the chart
        Cctx.beginPath();
        //ctx.strokeStyle = "red";
        Cctx.moveTo(blocks(5),blocks(40)); // move to position (0,0) on our axis

        var xPlot = 10;

        entries.forEach(function (val,idx){
            var populationBlocks = val[1][1]/100; //get the value
            Cctx.strokeStyle = "black";
            Cctx.lineWidth   = 2;
            Cctx.font="15pt Calibri";
            Cctx.strokeText(val[1][0],blocks(xPlot),blocks(40-populationBlocks-2)); //draw the text on its position
            Cctx.strokeStyle = color; // change the color to draw the line
            Cctx.lineWidth   = 3;
            Cctx.lineTo(blocks(xPlot),blocks(40-populationBlocks)); // draw line to the position of this point
            Cctx.arc(blocks(xPlot),blocks(40-populationBlocks),2,0,Math.PI*2,true); // draw small arc in the point
            xPlot+=5;
        });
        Cctx.stroke();
    }

    function reset(){
        Cctx.clearRect(0, 0, Ccanvas.width, Ccanvas.height);
        Cctx.font='10px Arial';
        Cctx.lineWidth   = 1;
    }
    function edit(col) {
        // when changing the color
        color = col;
        reset();
        drawGrids();
        drawAxis();
        drawChart();
    }
    function saveit() {

        var dataUrl = Ccanvas.toDataURL();
        document.getElementById("image").src = dataUrl;
        document.getElementById("download").href = dataUrl;
    }


    drawGrids();
    drawAxis();
    drawChart();
</script>

    <script>
        $(document).ready(function(){
            setInterval(function(){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:'/coordinate',
                    type:'GET',
                    dataType:'json',
                    success:function(response){
                        if(response.all.length>0){
                            values = JSON.parse(response.all);
                            entries = Object.entries(values);
                            //alert(values);
                            reset();
                            drawGrids();
                            drawAxis();
                            drawChart();
                        }
                    },error:function(err){

                    }
                })
            }, 3000);
        });
    </script>
@endsection