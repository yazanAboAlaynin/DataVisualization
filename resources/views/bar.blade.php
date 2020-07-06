<html>
<head>

    <script>
        function draw() {

            var values = {!! $all !!};

            //var values = 0;
            var canvas = document.getElementById('myCanvas');
            var ctx = canvas.getContext('2d');

            var width = 40; //bar width
            var X = 50; // first bar position
            var base = 200;

            for (var i =0; i<values.length; i++) {
                ctx.fillStyle = '#008080';
                var h = values[i][1];
                ctx.fillRect(X,canvas.height - h,width,h);

                X +=  width+15;
                /* text to display Bar number */
                ctx.fillStyle = '#4da6ff';
                ctx.fillText(values[i],X-50,canvas.height - h -10);
            }
            /* Text to display scale */
            ctx.fillStyle = '#000000';
            ctx.fillText('Scale X : '+canvas.width+' Y : '+canvas.height,800,10);


        }
        function reset(){
            var canvas = document.getElementById('myCanvas');
            var ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }



    </script>
</head>
<body align="center">

<input type="button" value="submit" name="submit" onclick="draw()">
<input type="button" value="Clear" name="Clear" onclick="reset()"><br><br>
<canvas id="myCanvas" width="900" height="500" style="border:1px solid #c3c3c3;">
</canvas>

</body>
</html>