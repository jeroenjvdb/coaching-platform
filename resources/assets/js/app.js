
/*!
 * main javascript
 */
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
        $('form').on('submit', formRequest);
    }

    function formRequest(e)
    {
        if($(e.target).data('ajax')) {
            e.preventDefault();
            var form = $(e.target);

            $.post(form[0].action,
                form.serialize(),
                formResponse,
                'json'
            );
        }
    }

    function formResponse(data)
    {
        console.log(data);
    }

    function renderImage()
    {
        console.log(this);
        readURL(this);
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
            };

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
            var elem = $(elems[i]);
            console.log();
            var swOptions = {
                stopwatch_id:   elem.data('stopwatch_id'),// ? stopwatch_id : 0,
                user_id:        elem.data('user_id') , //||0,
                url:            elem.data('url'),//stopwatch_store, // ||0,
                startClock:     elem.data('clock'), // || 0, clock
                lastTime:       elem.data('last'), // || 0, lastTime
                is_paused:      elem.data('paused'), // ||false, is_paused
                is_base3:       elem.data('base3'),
            };

            stopwatches[i] = new Stopwatch(elems[i], swOptions);
        }
    }
});