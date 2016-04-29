$(function () {
    init();

    function init() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
        });

        $('.page').each(function(item) {
            console.log($(this));
            $(this).on('click', showPage);
        });

        $('.pages div').hide().first().show();

        createTimers();
    }

    function showPage(page) {
        pageName = $(page.target).data('page');
        console.log(pageName);

        $('.pages div').hide();
        $('.pages div#' + pageName).show();
    }

    function createTimers() {
        var elems = $(".stopwatch");
        var stopwatches = [];
        var sWatch;

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
    }
});