var Stopwatch = function(elem, options ) {
    var timer,//       = createTimer(),
        startButton,// = createButton("start", startStop),
        //stopButton  = createButton("stop", stop),
        resetButton, // = createButton("reset", splitReset),
        splitSpan,
        lastSplitSpan,
        fullSplitSpan,
        //splitButton = createButton("split", split),
        offset,
        clock,
        interval,
        url,
        time; // = options.url;

    init();

    function init()
    {
        var divElem;
        console.log(options);
        if(options.records) {
            recordElem = createDiv('col-sm-6 col-sm-push-6');
            elem.appendChild(recordElem);

            var recordTitle = document.createElement('p');
            recordTitle.className = 'stopwatch-title';
            recordTitle.innerHTML = options.distance.distance + ' ' + options.stroke.name +
                ' - ' + options.swimmer.first_name + ' ' + options.swimmer.last_name;

            recordElem.appendChild(recordTitle);

            records = createRecords(options.records);
            recordElem.appendChild(records);

            divElem = createDiv('col-sm-6 col-sm-pull-6');

            elem.appendChild(divElem);

        } else {
            $.getJSON(options.recordsUrl, null, createRecordsUrl);
            var divClass = 'col-sm-6 ';
            if(! options.is_base3) {
                divClass += 'col-sm-pull-6';
            }
            divElem = createDiv(divClass);
            elem.appendChild(divElem);
        }

        console.log('test');

        timer       = createTimer();
        lastSplitSpan = createTimer();
        fullSplitSpan = createTimer();
        startButton = createButton("Start", startStop);
        //stopButton  = createButton("stop", stop),
        resetButton = createButton("Reset", splitReset);
        //splitButton = createButton("split", split),
        splitSpan = createSplitSpan();
        url = options.url;
        console.log(options);

        this.clock   = 0;

        // default options
        options = options || {};
        options.delay = options.delay || 1;

        // append elements
        if(!options.is_base3) {
            divElem.appendChild(lastSplitSpan);
            divElem.appendChild(fullSplitSpan);
        }
        divElem.appendChild(timer);
        elem.appendChild(createDiv("clearfix"));
        divButton = createDiv('col-xs-12 col-sm-6');
        elem.appendChild(divButton);
        divButton.appendChild(startButton);
        elem.appendChild(createDiv("clearfix"));
        //elem.appendChild(stopButton);
        if(! options.is_base3) {
            divButton.appendChild(resetButton);
        }
        elem.appendChild(document.createElement("br"));
        elem.appendChild(splitSpan);

        //elem.appendChild(splitButton);

        // initialize

        reset();
    }

    function createRecordsUrl(data)
    {
        console.log($(elem));

        divElem = createDiv('col-sm-6 col-sm-pull-6');

        $(elem).prepend(divElem);

        recordElem = createDiv('col-sm-6 col-sm-push-6');
        $(elem).prepend(recordElem);

        var recordTitle = document.createElement('p');
        recordTitle.className = 'stopwatch-title';
        recordTitle.innerHTML = data.distance.distance + ' ' + data.stroke.name +
            ' - ' + data.swimmer.first_name + ' ' + data.swimmer.last_name;

        recordElem.appendChild(recordTitle);

        records = createRecords(data.besttimes);
        recordElem.appendChild(records);

        return true;
    }

    function createRecords(records)
    {
        console.log(records);



        var recordElem = document.createElement('table');
        thead = document.createElement('thead');
        recordElem.appendChild(thead);
        recordElem.className = "stopwatch-table";
        //tr = recordElem.insertRow(-1);
        thead.innerHTML = '<th>Zwembad</th><th>Tijd</th>';
        tbody = document.createElement('tbody');
        recordElem.appendChild(tbody);
        for (var i = 0; i< records.length; i++) {
            tr = tbody.insertRow(-1);
            tr.innerHTML = records[i];
            console.log(tr);
        }

        return recordElem;
    }

    function createDiv(divClass)
    {
        var divElem = document.createElement('div');
        divElem.className = divClass;

        return divElem;

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
        a.className = "btn btn-primary btn-lg btn-full btn-sw";
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
        a.className = "list-unstyled col-xs-12 col-sm-6";

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
            startButton.innerHTML = 'Stop';
            resetButton.innerHTML = 'Split';
            offset = Date.now();
            interval = setInterval(update, options.delay);
            if(options.is_base3) {
                reset();
            }
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
            startButton.innerHTML = 'Start';
            resetButton.innerHTML = 'Reset';
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
            options.lastTime = options.startClock;
            lastSplitSpan.innerHTML = timeToString(0);
            fullSplitSpan.innerHTML = timeToString(0);
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

        //return /*'<div class="cell">' + Math.floor(hrs/10) + '</div>'<div class="cell">' + hrs % 10  + '</div>' +
            //'<div class="cell">:</div>' +*/
        return    '<div class="cell">' + Math.floor(s/10) + '</div><div class="cell">' + s%10 + '</div>' +
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
            //console.log(whut);
        }
    }

    /**
     * add split to html
     *
     * @param time
     */
    function appendSplit(time) {
        console.log(time);
        console.log(options.lastTime);
        if($(splitSpan).first().data('time') != time && clock != options.lastTime & clock != 0) {
            $(splitSpan).prepend('<li data-time="' + time + '">' + timeToString(time)  + ' <span class="small">' + timeToString(time - options.lastTime) + '</span>' + '</li>');
            lastSplitSpan.innerHTML = timeToString(time);
            fullSplitSpan.innerHTML = timeToString(time - options.lastTime);
        }
        options.lastTime = clock;
    }


    // public API
    this.start  = start;
    this.stop   = stop;
    this.reset  = reset;
    this.split  = split;
};