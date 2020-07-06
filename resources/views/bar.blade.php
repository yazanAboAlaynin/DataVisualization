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

                    <canvas id="myCanvas" width="900" height="500" style="border:1px solid #c3c3c3;">
                    </canvas>
                </div>
                <div class="col-lg-3">
                    <ul id="dvLegend"></ul>
                </div>
            </div>
        </div>




        <script>
            window.onload(
                draw()
            );
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
@endsection