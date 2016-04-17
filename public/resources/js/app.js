$(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
    });

    var Stopwatch = function(elem, options ) {

        var timer       = createTimer(),
            startButton = createButton("start", start),
            stopButton  = createButton("stop", stop),
            resetButton = createButton("reset", reset),
            splitButton = createButton("split", split),
            offset,
            clock,
            interval,
            url = options.url || '/s3/stopwatch/1/time';//,

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
                offset = Date.now();
                interval = setInterval(update, options.delay);
                if( options.is_paused ) {
                    options.is_paused = false;
                    send();
                }
            }
        }

        function startTimer() {
            options.is_paused = false;
            send();
            start();
        }

        function stop() {
            if (interval) {
                time = clock;
                clearInterval(interval);
                interval = null;
                options.is_paused = true;
                send();
            }
        }

        function reset() {
            clock = 0;

            if(! options.is_base3) {
                if (options.startClock) {
                    clock = parseInt(options.startClock);
                    if (options.lastTime && !options.is_paused) {
                        clock = clock + ( new Date().getTime() - options.lastTime );
                    }
                }
                if (!options.is_paused) {
                    start();
                }
            }

            render();
        }

        function update() {
            clock += delta();
            getTime();
            render();
        }

        function render() {
            var s = Math.round(clock);

            if(options.is_base3) {
                if(s > 1000)  {
                    strokes = 180 / (s/1000);
                    timer.innerHTML = Math.round(strokes);

                } else {
                    timer.innerHTML = 180;
                }
            } else {


                timer.innerHTML = timeToString(s);
            }
        }

        function delta() {
            var now = Date.now(),
                d   = now - offset;

            offset = now;
            return d;
        }

        function timeToString(s) {
            var ms = s % 1000;
            var hundredth = Math.round(ms/10);
            s = (s - ms) / 1000;
            var secs = s % 60;
            s = (s - secs) / 60;
            var mins = s % 60;
            var hrs = (s - mins) / 60;

            return hrs + ':' + mins + ':' + secs + '.' + hundredth;

        }

        function getTime() {
            //console.log(clock);
            this.clock = clock;
        }

        function split() {
            send();
        }

        function send() {
            if(! options.is_base3) {
                options.clock = clock;
                options.dt = Date.now();

                $.post(url, options, function(data){
                    console.log(data);
                    appendSplit(data.time)
                }, 'json');
            }
        }

        function appendSplit(time) {
            console.log(time);
            var splits = $('ul#splits');
            console.log(splits);
            splits.prepend('<li>' + timeToString(time) + '</li>');
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

    var elems = $(".stopwatch");
    console.log(elems);
    var stopwatches = [];

    for (var i=0, len=elems.length; i<len; i++) {
        console.log();
        var swOptions = {
            stopwatch_id: stopwatch_id,
            user_id: user_id,
            url: stopwatch_store,
            startClock: clock,
            lastTime: lastTime,
            is_paused: is_paused,
            is_base3: $(elems[i]).data('base3'),
        };

        stopwatches[i] = new Stopwatch(elems[i], swOptions);
    }
});

//# sourceMappingURL=app.js.map
