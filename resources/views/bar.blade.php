@extends('layouts.app')

@section('content')

        <div class="container justify-content-center">
            <div class="row pb-3">
                <div class="col-md-1">
                    <input class="btn btn-primary" type="button" value="show" name="show" onclick="draw()">

                </div>
                <div class="col-md-1">
                    <a id="download" href="#"  onclick="saveit()" download>download</a>

                </div>

            </div>


            <div class="row ">
                <div class="col-lg-6">

                    <canvas id="myCanvas" width="900" height="500" style="border:1px solid #c3c3c3;">
                    </canvas>
                    <img id="image" style="display: none;"/>
                </div>
                <div class="col-lg-3">
                    <ul id="dvLegend"></ul>
                </div>
            </div>
        </div>



<br/>
<br/>
<br/>
        <script>
            // colors we will use
            var colors = ['#4CAF50', '#00BCD4', '#E91E63', '#FFC107', '#9E9E9E', '#CDDC39', '#18FFFF', '#F44336', '#6D4C41','red', 'green', 'blue','gray','yellow','black','cyan','pink','purple','brown'];

            // values come from the controller when loading the page
            var values = {!! $all !!};
            // get the canvas by id
            var barCan = document.getElementById('myCanvas');
            // make 2d context to draw
            var barCtx = barCan.getContext('2d');

            function drawBar() {

                var width = 40; //bar width
                var X = 50; // first bar position
                // looping on the values to draw each rectangle
                for (var i =0; i<values.length; i++) {
                    barCtx.fillStyle = colors[i%colors.length]; // choose color for rectangle
                    var h = values[i][1]; // get the height of rectangle
                    // draw the rectangle (position on x,position on y,width of rectangle,height of rectangle)
                    barCtx.fillRect(X,barCan.height - h,width,h);

                    X +=  width+15; //increase the position on x to draw the next rectangle
                    /* text to display Bar number */
                    barCtx.fillStyle = '#4da6ff';
                    barCtx.fillText(values[i],X-50,barCan.height - h -10); // text on top of the rectangle
                }
                /* Text to display scale */
                barCtx.fillStyle = '#000000';
                barCtx.fillText('Scale X : '+barCan.width+' Y : '+barCan.height,800,10);


            }

            // to make action on mouse move
            barCan.onmousemove = function (e) {

                var rect = this.getBoundingClientRect(),
                    x = e.clientX - rect.left, //get the x position
                    y = e.clientY - rect.top; //get the y position

                // clear the exist rectangle
                barCtx.clearRect(0, 0, barCan.width, barCan.height);

                var width = 40; //bar width
                var X = 50; // first bar position

                //start drawing again
                for (var i =0; i<values.length; i++) {

                    var h = values[i][1];
                    barCtx.beginPath();
                    barCtx.rect(X,barCan.height - h,width,h);

                    // here is the difference : we change the bar color if mouse move above it
                    barCtx.fillStyle = barCtx.isPointInPath(x, y) ? "#008080" : colors[i%colors.length];
                    barCtx.fill();
                    X +=  width+15;
                    /* text to display Bar number */
                    barCtx.fillStyle = '#4da6ff';
                    barCtx.fillText(values[i],X-50,barCan.height - h -10);
                }
                /* Text to display scale */
                barCtx.fillStyle = '#000000';
                barCtx.fillText('Scale X : '+barCan.width+' Y : '+barCan.height,800,10);




            };

            function reset(){
                barCtx.clearRect(0, 0, barCan.width, barCan.height);
            }

            function saveit() {

                var dataUrl = barCan.toDataURL();
                document.getElementById("image").src = dataUrl;
                document.getElementById("download").href = dataUrl;
            }

            drawBar();

        </script>


@endsection