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
        //paging();

        var sortable = $('.sortable');
        sortable.sortable();
        sortable.sortable('disable');
        calendar();
        addEventListeners();
        $(window).trigger('resize');
        createTimers();
        checkboxes();
    }


    function calendar()
    {
        $('.calendar').each(function(){
            var url = $(this).data('url');
            console.log(url);
            $(this).fullCalendar({
                header: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'today'
                },
                events: {
                    url: url,
                    error: function() {
                        alert('error')
                    }
                },
            });
        })

    }

    function checkboxes()
    {
        $('.input_change_checkbox').each(function(){
            console.log($(this));
            var checked = "";
            if ($(this).is(':checked')) {
                checked = "checked";
            }
            $(this).hide().after('<div class="change_checkbox '+ checked
                +'"><img src="' + $(this).data('image') +
                '" alt=""></div>');

        });

        $('.change_checkbox').on('click',function(){
            $(this).toggleClass('checked').prev().prop('checked',$(this).is('.checked'))
        });
    }

    function addEventListeners()
    {
        $(window).on('resize', resize);
        $('.upload-image').on('change', renderImage);
        $('form').on('submit', formRequest);
        $('a').on('click', links);
        //$('.sort-bars').on('mousedown', function(e) { $('.sortable').sortable('enable'); console.log(e); })
        $('.sort-bars').on('touchstart mousedown', function(e) { $('.sortable').sortable('enable'); console.log(e); })
        $('.sort-bars').on('touchend mouseup', function(e) { $('.sortable').sortable('disable'); console.log(e); })
        $('.sortable').on('sortupdate', sort);
        //$('.sortable').on('sortstop', sortStop);
        $('.btn-page').on('click', showPage);
        var page = $('.page');
        page.on('swipeleft', swipePageLeft);
        page.on('swiperight', swipePageRight);
        $('.sidebar-toggle').on('click', function(){
            setTimeout(function(){
                $(window).trigger('resize');
            }, 250);
        })
    }

    function resize(e)
    {
        //delay(1000);
        console.log('resize');
        var cw = $('.swimmer-thumb').width();
        $('.swimmer-thumb').css({'height':cw+'px'});
    }

    function swipePageLeft(e)
    {
        //console.log(e);
        var nextPage = $(e.currentTarget).data('next');
        //console.log(nextPage);
        $('#' + nextPage).trigger('click');
    }

    function swipePageRight(e)
    {
        //console.log(e);
        var nextPage = $(e.currentTarget).data('prev');
        console.log('right');
        $('#' + nextPage).trigger('click');    }

    function sort(event, ui)
    {
        var id = ui.item.data('id');
        var tableClass = ui.item.data('class');
        var position = $('.' + tableClass).index(ui.item);
        var url = $('#' + ui.item.data('table')).data('url');
        $('.sortable').sortable('disable');
        console.log(ui.item);
        console.log('class ' + tableClass);
        console.log('id ' + id);
        console.log('position ' + position);
        console.log('url ' + url);

        updatePosition(id, position, url);
    }

    function sortStop(event, ui)
    {
        //console.log(sortStop);
        $('.sortable').sortable('disable');
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
        console.log(data);
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
                    elem.html('<a href="tel://' + data.data.contact.phone + '">' +
                        data.data.contact.phone + '</a>');
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
        console.log(this);
        readURL(this);
    }

    function readURL(input)
    {
        console.log('readURL')
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            console.log('input.files');
            reader.onload = function (e) {
                console.log($(input).data('img'));
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
        $('.btn-page').removeClass('active');
        pageName = $(page.target).data('page');
        //page.addClass('active');
        $(page.target).addClass('active');
        console.log(page.target);
        $('.pages>div').hide();
        $('.pages>div#' + pageName).show();
    }

    function createTimers() {
        var elems = $(".stopwatch");
        console.log(elems);
        var stopwatches = [];
        var sWatch;

        for (var i=0, len=elems.length; i<len; i++) {
            var elem = $(elems[i]);
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
        if (toggle && toggle != 'dropdown') {
            //console.log($('.' + toggle));
            var elems = $('.' + toggle);
            $.each(elems, function(index, value) {
                console.log($(value));
                if($(value).data('is_form')) {
                    //console.log('show');
                    $(value).show();
                    console.log($(value).find('input')[0]);
                    $(value).find('input')[1].focus();
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