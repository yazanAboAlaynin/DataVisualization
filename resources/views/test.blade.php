<html>
<head>

</head>
<body align="center">

<input type="button" value="submit" name="submit" onclick="draw()">
<input type="button" value="Clear" name="Clear" onclick="reset()"><br><br>
<canvas id="myCanvas" width="1000" height="500" style="border:1px solid black">
</canvas>
<script>

    var canvas = document.getElementById('myCanvas');

    var xGrid = 10;
    var yGrid = 10;
    var cellSize = 10;

    var ctx = canvas.getContext('2d');
    var values = {!! $all !!};
    var data = {
        jan: 1000,
        feb: 2700,
        mar: 500,
        july: 2100,
        aug: 3000,
        sep: 3000
    };

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
</body>
</html>