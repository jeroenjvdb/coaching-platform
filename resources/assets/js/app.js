
/*!
 * main javascript
 */
$(function () {
    init();

    function init() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
        });



        $('.pages>div').hide().first().show();

        var sortable = $('.sortable');
        sortable.sortable();
        sortable.sortable('disable');
        addEventListeners();
        createTimers();
    }

    function addEventListeners()
    {
        $('.upload-image').on('change', renderImage);
        $('form').on('submit', formRequest);
        $('a').on('click', links);
        //$('.sort-bars').on('mousedown', function(e) { $('.sortable').sortable('enable'); console.log(e); })
        $('.sort-bars').on('touchstart mousedown', function(e) { $('.sortable').sortable('enable'); console.log(e); })
        $('.sortable').on('sortupdate', sort);
        $('.btn-page').on('click', showPage);
        var page = $('.page');
        page.on('swipeleft', swipePageLeft);
        page.on('swiperight', swipePageRight);
    }

    function swipePageLeft(e)
    {
        console.log(e);
        var nextPage = $(e.currentTarget).data('next');
        console.log(nextPage);
        $('#' + nextPage).trigger('click');
    }

    function swipePageRight(e)
    {
        console.log(e);
        var nextPage = $(e.currentTarget).data('previous');
        console.log(nextPage);
        $('#' + nextPage).trigger('click');    }

    function sort(event, ui)
    {
        var id = ui.item.data('id');
        var tableClass = ui.item.data('class');
        var position = $('.' + tableClass).index(ui.item);
        var url = $('#' + ui.item.data('table')).data('url');
        $('.sortable').sortable('disable');
        console.log(ui.item);
        console.log(tableClass);
        console.log(id);
        console.log(position);
        console.log(url);

        updatePosition(id, position, url);
    }

    function updatePosition(id, position, url)
    {
        console.log('update position');
        console.log(url);

        $.post(url, {
            position: position,
            exercise_id: id,
        }, function(data) {
            console.log(data);
        }, "json");
    }

    function formRequest(e)
    {
        if($(e.target).data('ajax')) {
            e.preventDefault();
            var form = $(e.target);
            console.log(form);

            $.post(form[0].action,
                form.serialize(),
                formResponse,
                'json'
            );
        }
    }

    function formResponse(data)
    {
        //console.log(data);
        switch(data.form){
            case "contact":
                updateContact(data);
                break;
        }
    }

    function updateContact(data) {
        console.log(data);
        //console.log($('.contact-data'));
        var elems = $('.contact-data');

        $.each(elems, function(index, value) {
            var elem = $(value);
            //console.log();
            //console.log(index);
            switch(elem.data('contact')) {
                case 'swimmer.email':
                    elem.text(data.data.swimmer.email);
                    break;
                case 'swimmer.phone':
                    elem.text(data.data.contact.phone);
                    break;
                case 'address':
                    elem.html(data.data.contact.address.toString);
                    break;
                case 'email':
            }
        });

        var forms = $('.contact-form');
        console.log(forms)
        $.each(forms, function(index, value) {
            var elem = $(value);
            console.log(elem);
            if(elem.data('is_form')) {
                elem.hide();
            } else {
                elem.show();
            }
        })
    }

    function renderImage()
    {
        //console.log(this);
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
        //console.log(pageName);
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

    function links(e)
    {
        console.log($(e.currentTarget).data('toggle'));
        var toggle = $(e.currentTarget).data('toggle');
        if (toggle) {
            //console.log($('.' + toggle));
            var elems = $('.' + toggle);
            $.each(elems, function(index, value) {
                console.log($(value));
                if($(value).data('is_form')) {
                    //console.log('show');
                    $(value).show();
                } else {
                    //console.log('hide');
                    $(value).hide();
                }
            });
        }

    }

    function isHTML(str) {
        var a = document.createElement('div');
        a.innerHTML = str;
        for (var c = a.childNodes, i = c.length; i--; ) {
            if (c[i].nodeType == 1) return true;
        }
        return false;
    }


});