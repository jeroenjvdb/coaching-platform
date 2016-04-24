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

    /**
     * create timer element
     *
     * @returns {Element}
     */
    function createTimer() {
        return document.createElement("span");
    }

    /**
     * create button elements
     *
     * @param action
     * @param handler
     * @returns {Element}
     */
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

    /**
     * start the timer
     */
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

    /**
     * stop the timer
     */
    function stop() {
        if (interval) {
            time = clock;
            clearInterval(interval);
            interval = null;
            options.is_paused = true;
            send();
        }
    }

    /**
     * reset the timer
     */
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

    /**
     * update the clock
     */
    function update() {
        clock += delta();
        getTime();
        render();
    }

    /**
     * render the clock to the page
     */
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

    /**
     * calculate the time difference
     *
     * @returns {number}
     */
    function delta() {
        var now = Date.now(),
            d   = now - offset;

        offset = now;
        return d;
    }

    /**
     * create a formatted time string
     *
     * @param s
     * @returns {string}
     */
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

    /**
     * get the clock
     */
    function getTime() {
        //console.log(clock);
        this.clock = clock;
    }

    /**
     * create a time split
     */
    function split() {
        send();
    }

    /**
     * send the request
     */
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

    /**
     * add split to html
     *
     * @param time
     */
    function appendSplit(time) {
        var splits = $('ul#splits');
        var firstSplit = $('ul#splits li');
        if(firstSplit.first().data('time') != time) {
            splits.prepend('<li data-time="' + time + '">' + timeToString(time) + '</li>');
        }
    }


    // public API
    this.start  = start;
    this.stop   = stop;
    this.reset  = reset;
    this.split  = split;
};