/*!
 * main javascript
 */
$(function () {
    init();

    function init() {
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
        });


        $('.pages>div').hide().first().show();
        //paging();
        //$('.datetimepicker').datetimepicker();
        //$('#datetimepicker1').datetimepicker();
        var sortable = $('.sortable');
        sortable.sortable();
        sortable.sortable('disable');
        $('.select2').select2();
        addEventListeners();
        calendar();
        charts();
        forms();
        daterangepicker();

        $(window).trigger('resize');
        createTimers();
    }

    function cb(start, end) {
        $('#daterangepicker span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        updateCharts(start, end);
    }

    function daterangepicker() {
        cb(moment().subtract(29, 'days'), moment());

        console.log($('#daterangepicker'));
        $('#daterangepicker').first().daterangepicker({
            ranges: {
                //'Today': [moment(), moment()],
                //'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'Last 90 Days': [moment().subtract(89, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
    }

    function forms() {
        checkboxes();
        $("#compose-textarea").wysihtml5();
        var forms = $('form');
        forms.each(function () {
            var form = $(this);
            formHtml = this;

            var checkedChange = form.is(function () {
                var thisForm = $(this);

                return thisForm.data('checked-submit');
            });
            if (checkedChange) {
                var checkbox = form.find('input[type=checkbox]');
                console.log(form);
                console.log(document.getElementById('test-form'));
                checkbox.on('click', function () {
                    console.log(form);
                    console.log(form.find('input[type=submit]'));
                    form.find('input[type=submit]').trigger('click');
                    console.log(form);
                });
                //console.log();

            }
        });

    }

    function charts() {
        var charts = $('.chart');

        charts.each(function (index, chart) {
            var url = $(chart).data('url');

            $.getJSON(url, function (data) {
                console.log(data);
                console.log(chart);
                new ChartConfig(chart, data)
            });
        });
        //$('.chart').each(function(elem)
        //{
        //    console.log($(elem));
        //});
    }

    function updateCharts(start, end)
    {
        console.log('update charts');
        console.log(start.toISOString());
        console.log(end);
        var charts = $('.chart');

        charts.each(function (index, chart) {
            var url = $(chart).data('url');

            $.getJSON(url, {
                start: start.toISOString(),
                end: end.toISOString(),
            }, function (data) {
                console.log(data);
                console.log(chart);
                new ChartConfig(chart, data)
            });
        });
    }


    function calendar() {
        $('.calendar').each(function () {
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
                    error: function () {
                        alert('error')
                    }
                },
            });
        })

    }

    function checkboxes() {
        $('input[type=checkbox].line').each(function(){
            var self = $(this),
                label = self.next(),
                label_text = label.text();

            label.remove();
            self.iCheck({
                checkboxClass: 'icheckbox_line',
                radioClass: 'iradio_line',
                insert: '<div class="icheck_line-icon"></div>' + label_text
            });
        });

        $('.input_change_checkbox').each(function () {
            var checked = "";
            if ($(this).is(':checked')) {
                checked = "checked";
            }
            $(this).hide().after('<div class="change_checkbox ' + checked
                + '"><img src="' + $(this).data('image') +
                '" alt=""></div>');

        });

        $('input[type=checkbox]').each(function() {
            if($(this).data('all')) {
                $(this).on('ifClicked', function(e)
                {
                    var source = this;
                    console.log($(source).is(':checked'));
                    var name = $(this).data('checkbox');
                    console.log($('input[type=checkbox][name=' + name + ']'));
                    $('input[type=checkbox][data-name=' + name + ']').each(function() {
                        this.checked = !source.checked;
                        console.log(this.checked);
                        $(this).iCheck('update');
                    })

                })
            }
        })

        $('.change_checkbox').on('click', function () {
            $(this).toggleClass('checked').prev().prop('checked', $(this).is('.checked'))
        });
    }

    function addEventListeners() {
        $(window).on('resize', resize);
        $('.upload-image').on('change', renderImage);
        $('form').on('submit', formRequest);
        $('a').on('click', links);
        $('.sort-bars').on('touchstart mousedown', function (e) {
            $('.sortable').sortable('enable');
            console.log(e);
        });
        $('.sort-bars').on('touchend mouseup', function (e) {
            $('.sortable').sortable('disable');
            console.log(e);
        });
        $('.sortable').on('sortupdate', sort);
        //$('.sortable').on('sortstop', sortStop);
        $('.btn-page').on('click', showPage);
        var page = $('.page');
        page.on('swipeleft', swipePageLeft);
        page.on('swiperight', swipePageRight);
        $('.sidebar-toggle').on('click', function () {
            setTimeout(function () {
                $(window).trigger('resize');
            }, 250);
        })
    }

    function resize(e) {
        //delay(1000);
        console.log('resize');
        var cw = $('.swimmer-thumb').width();
        $('.swimmer-thumb').css({'height': cw + 'px'});
    }

    function swipePageLeft(e) {
        //console.log(e);
        var nextPage = $(e.currentTarget).data('next');
        //console.log(nextPage);
        $('#' + nextPage).trigger('click');
    }

    function swipePageRight(e) {
        //console.log(e);
        var nextPage = $(e.currentTarget).data('prev');
        console.log('right');
        $('#' + nextPage).trigger('click');
    }

    function sort(event, ui) {
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

    function sortStop(event, ui) {
        //console.log(sortStop);
        $('.sortable').sortable('disable');
    }

    function updatePosition(id, position, url) {
        console.log('update position');
        console.log(url);

        $.post(url, {
            position: position,
            exercise_id: id,
        }, function (data) {
            console.log(data);
        }, "json");
    }

    function formRequest(e) {
        console.log('form request');
        console.log(e);
        if ($(e.target).data('ajax')) {
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

    function formResponse(data) {
        console.log(data);
        switch (data.form) {
            case "contact":
                updateContact(data);
                break;
            case "timer":
                createNewTimer(data);
        }
    }

    function updateContact(data) {
        console.log(data);
        //console.log($('.contact-data'));
        var elems = $('.contact-data');

        $.each(elems, function (index, value) {
            var elem = $(value);
            console.log(elem);

            //console.log(index);
            switch (elem.data('contact')) {
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
                    elem.html(data.data.email);
            }
        });

        var forms = $('.contact-form');
        console.log(forms)
        $.each(forms, function (index, value) {
            var elem = $(value);
            console.log(elem);
            if (elem.data('is_form')) {
                elem.hide();
            } else {
                elem.show();
            }
        })
    }

    function renderImage() {
        console.log(this);
        var fileReader = new FileReader();



        readURL(this);
    }

    function readURL(input) {
        console.log('readURL')
        if (input.files && input.files[0]) {
            var reader = new FileReader;
            console.log('input.files');
            reader.onload = function (e) {
                console.log(reader);
                //var arrayBufferView = new Uint8Array( this.result );
                //var blob = new Blob( [ arrayBufferView ], { type: "image/jpeg" } );
                console.log(input.files[0]);
                var exif = get_exif_data(this.result)

                console.log(exif);

                switch(exif.Orientation){

                    case 8:
                        ctx.rotate(90*Math.PI/180);
                        break;
                    case 3:
                        ctx.rotate(180*Math.PI/180);
                        break;
                    case 6:
                        ctx.rotate(-90*Math.PI/180);
                        break;


                }
                console.log($(input).data('img'));
                if ($(input).data('img') == 'start') {
                    $('#image-start').attr('src', e.target.result);
                } else {
                    $('#image-end').attr('src', e.target.result);
                }
            };

            /*reader.onloadend = function(e) {
             console.log(e);
             var exif = EXIF.readFromBinaryFile(new BinaryFile(this.result));

             console.log(exif);

             switch(exif.Orientation){

             case 8:
             ctx.rotate(90*Math.PI/180);
             break;
             case 3:
             ctx.rotate(180*Math.PI/180);
             break;
             case 6:
             ctx.rotate(-90*Math.PI/180);
             break;


             }
             };*/

            reader.readAsDataURL(input.files[0]);
        }
    }

    function get_exif_data(image_result)
    {
        var data = image_result.replace("data:image/jpeg;base64,", "");
        var decoded_data = decode64(data);

        getLongAt = function(iOffset, bBigEndian) {
            var iByte1 = decoded_data.charCodeAt(iOffset),
                iByte2 = decoded_data.charCodeAt(iOffset + 1),
                iByte3 = decoded_data.charCodeAt(iOffset + 2),
                iByte4 = decoded_data.charCodeAt(iOffset + 3);
            var iLong = bBigEndian ?
            (((((iByte1 << 8) + iByte2) << 8) + iByte3) << 8) + iByte4
                : (((((iByte4 << 8) + iByte3) << 8) + iByte2) << 8) + iByte1;
            if (iLong < 0) iLong += 4294967296;
            return iLong;
        };

        getSLongAt = function(iOffset, bBigEndian) {
            var iULong = getLongAt(iOffset, bBigEndian);
            if (iULong > 2147483647)
                return iULong - 4294967296;
            else
                return iULong;
        };

        var result = findEXIFinJPEG({
            getByteAt: function(idx) { return decoded_data.charCodeAt(idx); },
            getLength: function() { return decoded_data.length; },
            getShortAt: function(iOffset, bBigEndian) {
                var iShort = bBigEndian ?
                (decoded_data.charCodeAt(iOffset) << 8) + decoded_data.charCodeAt(iOffset + 1)
                    : (decoded_data.charCodeAt(iOffset + 1) << 8) + decoded_data.charCodeAt(iOffset)
                if (iShort < 0) iShort += 65536;
                return iShort;
            },
            getStringAt: function(a, b) { return decoded_data.substring(a, a+b); },
            getLongAt: getLongAt,
            getSLongAt: getSLongAt
        });
        return result;
    }

    function decode64(input) {
        var keyStr = "ABCDEFGHIJKLMNOP" +
            "QRSTUVWXYZabcdef" +
            "ghijklmnopqrstuv" +
            "wxyz0123456789+/" +
            "=";

        var output = "";
        var chr1, chr2, chr3 = "";
        var enc1, enc2, enc3, enc4 = "";
        var i = 0;
        // remove all characters that are not A-Z, a-z, 0-9, +, /, or =
        var base64test = /[^A-Za-z0-9\+\/\=]/g;
        if (base64test.exec(input)) {
            alert("There were invalid base64 characters in the input text.\n" +
                "Valid base64 characters are A-Z, a-z, 0-9, '+', '/',and '='\n" +
                "Expect errors in decoding.");
        }
        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
        do {
            enc1 = keyStr.indexOf(input.charAt(i++));
            enc2 = keyStr.indexOf(input.charAt(i++));
            enc3 = keyStr.indexOf(input.charAt(i++));
            enc4 = keyStr.indexOf(input.charAt(i++));
            chr1 = (enc1 << 2) | (enc2 >> 4);
            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
            chr3 = ((enc3 & 3) << 6) | enc4;
            output = output + String.fromCharCode(chr1);
            if (enc3 != 64) {
                output = output + String.fromCharCode(chr2);
            }
            if (enc4 != 64) {
                output = output + String.fromCharCode(chr3);
            }
            chr1 = chr2 = chr3 = "";
            enc1 = enc2 = enc3 = enc4 = "";
        } while (i < input.length);
        return unescape(output);
    }

    function showPage(page) {
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

        for (var i = 0, len = elems.length; i < len; i++) {
            var elem = $(elems[i]);
            var swOptions = {
                stopwatch_id: elem.data('stopwatch_id'),// ? stopwatch_id : 0,
                user_id: elem.data('user_id'), //||0,
                swimmer_id: elem.data('swimmer_id'),
                url: elem.data('url'),//stopwatch_store, // ||0,
                startClock: elem.data('clock'), // || 0, clock
                lastTime: elem.data('last'), // || 0, lastTime
                is_paused: elem.data('paused'), // ||false, is_paused
                is_base3: elem.data('base3'),
            };

            stopwatches[i] = new Stopwatch(elems[i], swOptions);
        }
    }

    function createNewTimer(data)
    {
        console.log(data);
        elem = $('#newStopwatch').prepend('<div class="stopwatch"></div>');
        console.log(elem.find('.stopwatch')[0]);
        var swOptions = {
            //stopwatch_id: elem.data('stopwatch_id'),// ? stopwatch_id : 0,
            //user_id: elem.data('user_id'), //||0,
            //swimmer_id: elem.data('swimmer_id'),
            url: data.route,//stopwatch_store, // ||0,
            startClock: 0, // || 0, clock
            lastTime: 0, // || 0, lastTime
            is_paused: true, // ||false, is_paused
            is_base3: false,
        };

        new Stopwatch(elem.find('.stopwatch')[0], swOptions);
    }

    function links(e) {
        console.log($(e.currentTarget).data('toggle'));
        var toggle = $(e.currentTarget).data('toggle');
        if (toggle && toggle != 'dropdown') {
            //console.log($('.' + toggle));
            var elems = $('.' + toggle);
            $.each(elems, function (index, value) {
                console.log($(value));
                if ($(value).data('is_form')) {
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
        for (var c = a.childNodes, i = c.length; i--;) {
            if (c[i].nodeType == 1) return true;
        }
        return false;
    }


});