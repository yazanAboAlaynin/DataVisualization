@extends('layouts.app')

@section('content')

    <div class="container justify-content-center">
        <div class="row pb-3">
            <div class="col-md-1">
                <input class="btn btn-primary" type="button" value="show" name="show" onclick="draw()">
            </div>
            <div class="col-md-1">
                <input class="btn btn-primary" type="button" value="Clear" name="Clear" onclick="reset()">
            </div>
        </div>


        <div class="row ">
            <div class="col-lg-6">

                <canvas id="myCanvas" width="1000" height="500" style="border:1px solid black">
                </canvas>
            </div>
            <div class="col-lg-3">
                <ul id="dvLegend"></ul>
            </div>
        </div>
    </div>


<script>

    var canvas = document.getElementById('myCanvas');

    var xGrid = 10;
    var yGrid = 10;
    var cellSize = 10;

    var ctx = canvas.getContext('2d');
    var values = {!! $all !!};


    const entries = Object.entries(values);


    function drawGrids() {
        ctx.beginPath();

        while(xGrid < canvas.height){
            ctx.moveTo(0,xGrid);
            ctx.lineTo(canvas.width,xGrid);
            xGrid+=cellSize;
        }

        while(yGrid < canvas.width){
            ctx.moveTo(yGrid,0);
            ctx.lineTo(yGrid,canvas.height);
            yGrid+=cellSize;
        }
        ctx.strokeStyle = "gray";
        ctx.stroke();
    }

    function blocks(count){
        return count*10;
    }

    function drawAxis(){
        var yPlot = 40;
        var pop = 0;

        ctx.beginPath();
        ctx.strokeStyle = "black";
        ctx.moveTo(blocks(5),blocks(5));
        ctx.lineTo(blocks(5),blocks(40));
        ctx.lineTo(blocks(80),blocks(40));

        ctx.moveTo(blocks(5),blocks(40));

        for(var i=1;i<=10;i++){
            ctx.strokeText(pop,blocks(2),blocks(yPlot));
            yPlot-=5;
            pop+=500;
        }

        ctx.stroke();

    }

    function drawChart() {
        ctx.beginPath();
        ctx.strokeStyle = "red";
        ctx.moveTo(blocks(5),blocks(40));

        var xPlot = 10;

        entries.forEach(function (val,idx){
            var populationBlocks = val[1][1]/100;

            ctx.strokeStyle = "black";
            ctx.strokeText(val[1][0],blocks(xPlot),blocks(40-populationBlocks-2));
            ctx.strokeStyle = "red";
            ctx.lineTo(blocks(xPlot),blocks(40-populationBlocks));
            ctx.arc(blocks(xPlot),blocks(40-populationBlocks),2,0,Math.PI*2,true);
            xPlot+=5;
        });
        ctx.stroke();
    }

    drawGrids();
    drawAxis();
    drawChart();
</script>
@endsection