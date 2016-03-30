@extends('layouts.master')

@section('content')
    <!-- create 3 stopwatches -->
    <div class="stopwatch"></div>
    <ul>
        @foreach($stopwatch->times as $time)
            <li>{{ $time->time->toString }}</li>
        @endforeach
    </ul>



@stop

@section('scripts')

    <script>
        $(function () {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
            });
        });

        var Stopwatch = function(elem, options ) {

            var timer       = createTimer(),
                    startButton = createButton("start", start),
                    stopButton  = createButton("stop", stop),
                    resetButton = createButton("reset", reset),
                    splitButton = createButton("split", split),
                    offset,
                    clock,
                    interval;

            var time;
            this.clock   = 0;



            // default options
            options = options || {};
            options.delay = options.delay || 1;

            // append elements
            elem.appendChild(timer);
            elem.appendChild(startButton);
            elem.appendChild(stopButton);
            elem.appendChild(resetButton);
            elem.appendChild(splitButton);

            // initialize
            reset();

            // private functions
            function createTimer() {
                return document.createElement("span");
            }

            function createButton(action, handler) {
                var a = document.createElement("a");
                a.href = "#" + action;
                a.setAttribute('class',  action);
                a.innerHTML = action;
                a.addEventListener("click", function(event) {
                    handler();
                    event.preventDefault();
                });
                return a;
            }

            function start() {
                if (!interval) {
                    offset   = Date.now();
                    interval = setInterval(update, options.delay);
                }
            }

            function stop() {
                if (interval) {
                    time = clock;
                    clearInterval(interval);
                    interval = null;
                }
            }



            function reset() {
                clock = 0;
                render();
            }

            function update() {
                clock += delta();
                getTime();
                render();
            }

            function render() {
                timer.innerHTML = clock/1000;
            }

            function delta() {
                var now = Date.now(),
                        d   = now - offset;

                offset = now;
                return d;
            }

            function getTime() {
                //console.log(clock);
                this.clock = clock;
            }

            function split() {
                console.log(clock);
                options.clock= clock;

                $.post('/s3/stopwatch/1/time', options, function(data){
                    console.log(data);
                }, 'json')
            }

            this.clock = function(){
                return clock;
            }

            // public API
            this.start  = start;
            this.stop   = stop;
            this.reset  = reset;
            this.split  = split;
        };

        var elems = document.getElementsByClassName("stopwatch");
        var stopwatches = [];
        var swOptions = {
            stopwatch_id: 1,
        }
        for (var i=0, len=elems.length; i<len; i++) {
            stopwatches[i] = new Stopwatch(elems[i], swOptions);
        }

    </script>

@stop