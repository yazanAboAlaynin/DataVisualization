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
            var canvas = document.getElementById('myCanvas');
            // make 2d context to draw
            var ctx = canvas.getContext('2d');

            function draw() {

                var width = 40; //bar width
                var X = 50; // first bar position
                // looping on the values to draw each rectangle
                for (var i =0; i<values.length; i++) {
                    ctx.fillStyle = colors[i%colors.length]; // choose color for rectangle
                    var h = values[i][1]; // get the height of rectangle
                    // draw the rectangle (position on x,position on y,width of rectangle,height of rectangle)
                    ctx.fillRect(X,canvas.height - h,width,h);

                    X +=  width+15; //increase the position on x to draw the next rectangle
                    /* text to display Bar number */
                    ctx.fillStyle = '#4da6ff';
                    ctx.fillText(values[i],X-50,canvas.height - h -10); // text on top of the rectangle
                }
                /* Text to display scale */
                ctx.fillStyle = '#000000';
                ctx.fillText('Scale X : '+canvas.width+' Y : '+canvas.height,800,10);


            }

            // to make action on mouse move
            canvas.onmousemove = function (e) {

                var rect = this.getBoundingClientRect(),
                    x = e.clientX - rect.left, //get the x position
                    y = e.clientY - rect.top; //get the y position

                // clear the exist rectangle
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                var width = 40; //bar width
                var X = 50; // first bar position
                var base = 200;

                //start drawing again
                for (var i =0; i<values.length; i++) {

                    var h = values[i][1];
                    ctx.beginPath();
                    ctx.rect(X,canvas.height - h,width,h);

                    // here is the difference : we change the bar color if mouse move above it
                    ctx.fillStyle = ctx.isPointInPath(x, y) ? "#008080" : colors[i%colors.length];
                    ctx.fill();
                    X +=  width+15;
                    /* text to display Bar number */
                    ctx.fillStyle = '#4da6ff';
                    ctx.fillText(values[i],X-50,canvas.height - h -10);
                }
                /* Text to display scale */
                ctx.fillStyle = '#000000';
                ctx.fillText('Scale X : '+canvas.width+' Y : '+canvas.height,800,10);




            };

            function reset(){
                ctx.clearRect(0, 0, canvas.width, canvas.height);
            }

            function saveit() {

                var dataUrl = canvas.toDataURL();
                document.getElementById("image").src = dataUrl;
                document.getElementById("download").href = dataUrl;
            }

            draw();

        </script>

    <script>
        // calling ajax every 3 second
        $(document).ready(function(){
            setInterval(function(){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:'/bar',
                    type:'GET',
                    dataType:'json',
                    success:function(response){
                        if(response.all.length>0){
                            // update the value and draw again
                            values = JSON.parse(response.all);
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