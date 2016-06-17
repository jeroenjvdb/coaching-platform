var Stopwatch = function(elem, options ) {
    var timer,//       = createTimer(),
        startButton,// = createButton("start", startStop),
        //stopButton  = createButton("stop", stop),
        resetButton, // = createButton("reset", splitReset),
        splitSpan,
        //splitButton = createButton("split", split),
        offset,
        clock,
        interval,
        url,
        time; // = options.url;

    init();

    function init()
    {
        timer       = createTimer();
        startButton = createButton("start", startStop);
        //stopButton  = createButton("stop", stop),
        resetButton = createButton("reset", splitReset);
        //splitButton = createButton("split", split),
        splitSpan = createSplitSpan();
        url = options.url;

        this.clock   = 0;

        // default options
        options = options || {};
        options.delay = options.delay || 1;

        // append elements
        elem.appendChild(timer);
        elem.appendChild(document.createElement("br"));
        elem.appendChild(startButton);
        //elem.appendChild(stopButton);
        //if( options.is_base3) {
            elem.appendChild(resetButton);
        //}
        elem.appendChild(document.createElement("br"));
        elem.appendChild(splitSpan);

        //elem.appendChild(splitButton);

        // initialize

        reset();
    }

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
        var a = document.createElement("button");
        a.href = "#" + action;
        a.setAttribute('class',  action);
        a.innerHTML = action;
        a.className = "btn btn-primary btn-lg"
        a.addEventListener("click", function(event) {
            handler();
            event.preventDefault();
        });
        return a;
    }

    function createSplitSpan()
    {
        var a = document.createElement("span");
        a.setAttribute('class',  'splits');
        a.className = "list-unstyled";

        return a;
    }

    function startStop()
    {
        if(! interval) {
            start();
        } else {
            stop();
        }

    }

    function splitReset()
    {
        if(interval) {
            split();
        } else {
            reset();
        }
    }

    /**
     * start the timer
     */
    function start() {
        if (!interval) {
            console.log(startButton);
            startButton.innerHTML = 'stop';
            resetButton.innerHTML = 'split';
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
            startButton.innerHTML = 'start';
            resetButton.innerHTML = 'reset';
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
                console.log(options.startClock);
                console.log(clock);
                if (options.lastTime && !options.is_paused) {
                    clock = clock + ( new Date().getTime() - options.lastTime );
                    console.log(new Date().getTime());
                    console.log(options.lastTime);
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
        var s = Math.floor(clock);

        if(options.is_base3) {
            if(s > 1000)  {
                strokes = 180 / (s/1000);
                hundred = Math.floor(strokes/100);
                strokes = strokes%100;
                ten     = Math.floor(strokes/10);
                strokes = strokes%10;
                one     = Math.floor(strokes);
                timer.innerHTML = '<div class="cell">'+ hundred +'</div><div class="cell">' +
                    ten + '</div><div class="cell">' +
                    one
                    + '</div>';

            } else {
                timer.innerHTML = '<div class="cell">1</div><div class="cell">8</div><div class="cell">0</div>';
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
        var hundredth = Math.floor(ms/10);
        s = (s - ms) / 1000;
        var secs = s % 60;
        s = (s - secs) / 60;
        var mins = s % 60;
        var hrs = (s - mins) / 60;

        return '<div class="cell">' + Math.floor(hrs/10) + '</div><div class="cell">' + hrs % 10  + '</div>' +
            '<div class="cell">:</div>' +
            '<div class="cell">' + Math.floor(mins/10) + '</div><div class="cell">' + mins%10 + '</div>' +
            '<div class="cell">:</div>' +
            '<div class="cell">' + Math.floor(secs/10) + '</div><div class="cell">' + secs%10 + '</div>' +
            '<div class="cell">.</div>' +
            '<div class="cell">' + Math.floor(hundredth/10) + '</div><div class="cell">' + hundredth%10 + '</div>';
    }

    /**
     * get the clock
     */
    function getTime() {
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
            console.log(options.clock);

            $.post(url, options, function(data){
                console.log(data);
                //appendSplit(data.time)
            }, 'json');

            appendSplit(options.clock);
        }
    }

    /**
     * add split to html
     *
     * @param time
     */
    function appendSplit(time) {
        console.log(splitSpan);
        if($(splitSpan).first().data('time') != time && clock != options.lastTime & clock != 0) {
            $(splitSpan).prepend('<li data-time="' + time + '">' + timeToString(time)  + '<div class="small">' + timeToString(time - options.lastTime) + '</div>' + '</li>');
        }
        options.lastTime = clock;
    }


    // public API
    this.start  = start;
    this.stop   = stop;
    this.reset  = reset;
    this.split  = split;
};