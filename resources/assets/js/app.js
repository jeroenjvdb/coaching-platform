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

        $('.pages>div').hide().first().show();

        addEventListeners();
        createTimers();
    }

    function addEventListeners()
    {
        $('.upload-image').on('change', renderImage);
    }

    function renderImage()
    {
        console.log(this);
    }

    function readURL(input)
    {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                if($(input).data('img') == 'start') {
                    $('#image-start').attr('src', e.target.result);
                } else {
                    $('#image-end').attr('src', e.target.result);
                }
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function showPage(page)
    {
        pageName = $(page.target).data('page');
        console.log(pageName);
        $('.pages>div').hide();
        $('.pages>div#' + pageName).show();
    }

    function createTimers() {
        var elems = $(".stopwatch");
        var stopwatches = [];
        var sWatch;

        for (var i=0, len=elems.length; i<len; i++) {
            console.log();
            var swOptions = {
                stopwatch_id: 0,// stopwatch_id ? stopwatch_id : 0,
                user_id: 0,//user_id ||0,
                url: 0,//stopwatch_store ||0,
                startClock: 0,//clock || 0,
                lastTime: 0,//lastTime || 0,
                is_paused:false,// is_paused ||false,
                is_base3: $(elems[i]).data('base3'),
            };

            stopwatches[i] = new Stopwatch(elems[i], swOptions);
        }
    }
});