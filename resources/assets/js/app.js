/*!
 * main javascript
 */
var allCharts = [];

$(function () {
    init();
    var nextPage, prevPage, extraNavPos;

    function init() {
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
        });


        $('.pages > div').hide().first().show();
        //paging();
        //$('.datetimepicker').datetimepicker();
        //$('#datetimepicker1').datetimepicker();
        var sortable = $('.sortable');
        sortable.sortable();
        sortable.sortable('disable');
        $('.select2').select2({
            width: '100%'
        });
        addEventListeners();
        calendar();
        charts();
        forms();
        daterangepicker();

        $(window).trigger('resize');
        createTimers();
        trainingTriggerEdit();
    }

    function trainingTriggerEdit() {
        var usersList = $('.users-list.training-presences');
        console.log(usersList);
        if (!usersList.children().length) {
            modalSelector = usersList.data('modal');
            console.log(modalSelector);
            $(modalSelector).modal('show');
        }
    }

    function cb(start, end) {
        $('#daterangepicker span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        updateCharts(start, end);
    }

    function daterangepicker() {
        cb(moment().subtract(90, 'days'), moment());

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
        datetimes();
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
                checkbox.on('click', function () {
                    form.find('input[type=submit]').trigger('click');
                });
                //console.log();

            }
        });

    }

    function datetimes() {
        $('#dtbox').DateTimePicker({
            'dateTimeFormat': 'yyyy-mm-dd hh:mm',
            'minuteInterval': 15,
            'language': 'nl',
            //'incrementButtonContent' : '<span class="increment"><i class="fa fa-angle-up"></i></span>',
            //decrementButtonContent: '<span class="increment"><i class="fa fa-angle-down"></i></span>',
        });
    }

    function charts() {
        var charts = $('.chart');

        charts.each(function (index, chart) {
            var url = $(chart).data('url');

            $.getJSON(url, function (data) {
                thisChart = new ChartConfig(chart, data);
                allCharts.push(thisChart);
            });
        });
        //$('.chart').each(function(elem)
        //{
        //});
    }

    function updateCharts(start, end) {
        var presences = $('#presences.progress-bar');
        if (presences.first()) {
            console.log('in presences');
            console.log(presences);
            url = presences.first().data('url');
            console.log(url);
            $.getJSON(url, {
                start: start.toISOString(),
                end: end.toISOString(),
            }, function (data) {
                console.log(data);
                presences.first().css('width', ( data.presences ) * 100 + '%').text((data.presences * 100) + '%');
            })
        }
        var charts = $('.chart');

        charts.each(function (index, chart) {
            var url = $(chart).data('url');

            $.getJSON(url, {
                start: start.toISOString(),
                end: end.toISOString(),
            }, function (data) {
                new ChartConfig(chart, data)
            });
        });
    }


    function calendar() {
        $('.calendar').each(function () {
            var url = $(this).data('url');
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
        $('input[type=checkbox].line').each(function () {
            var self = $(this),
                label = self.next(),
                label_text = label.text();

            label.remove();
            self.iCheck({
                checkboxClass: 'icheckbox_line-red',
                radioClass: 'iradio_line-red',
                insert: '<div class="icheck_line-icon"></div>' + label_text
            });
        });

        /*$('.input_change_checkbox').each(function () {
         var checked = "";
         if ($(this).is(':checked')) {
         checked = "checked";
         }
         $(this).hide().after('<div class="change_checkbox ' + checked
         + '"><img src="' + $(this).data('image') +
         '" alt=""></div>');

         });*/

        $('input[type=checkbox]').each(function () {
            if ($(this).data('all')) {
                $(this).on('ifClicked', function (e) {
                    var source = this;
                    var name = $(this).data('checkbox');
                    $('input[type=checkbox][data-name=' + name + ']').each(function () {
                        this.checked = !source.checked;
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
        });
        $('.sort-bars').on('touchend mouseup', function (e) {
            $('.sortable').sortable('disable');
            console.log(e);
        });
        $('.sortable').on('sortupdate', sort);
        //$('.sortable').on('sortstop', sortStop);
        $('.btn-page').on('click', showPage);
        swipeEvents();
        $('.sidebar-toggle').on('click', function () {
            setTimeout(function () {
                $(window).trigger('resize');
            }, 250);
        });
        $('.modal').on('show.bs.modal', function () {
            setTimeout(function () {
                $(window).trigger('resize');
            }, 250);
        });
        extraNav = $('#navigation-sticky');
        if (extraNav.length) {
            extraNavPos = extraNav.offset();
            $(window).scroll(function () {

                if ($(window).scrollTop() > extraNavPos.top) {
                    $('#navigation-sticky').addClass('scrolling');
                } else {
                    $('#navigation-sticky').removeClass('scrolling');
                }
            });
        }


        showStopwatchTimes();
    }

    function showStopwatchTimes() {
        var ListLengthHidingTrigger = 4;
        var InitialListItems = 3;


        $.each($('.splits'), function () {
            var thisElem = $(this);
            if (thisElem.find('li').length > ListLengthHidingTrigger) {
                thisElem.find("li:gt(" + (InitialListItems - 1) + ")").hide(); // hide all but first N sections
                thisElem.find('.toggle-more').html('meer');
            }

            $(this).find('.toggle-more').on('click', function () {
                if (!$(this).data('collapse')) {
                    thisElem.find('li').show(); // hide all but first 2 sections
                    thisElem.find('.toggle-more').html('minder');
                    $(this).data('collapse', true);

                } else {
                    thisElem.find("li:gt(" + (InitialListItems - 1) + ")").hide(); // hide all but first N sections
                    $(this).data('collapse', false);
                    thisElem.find('.toggle-more').html('meer');


                }
                //thisElem.find('li').show();
                //thisElem.find('.toggle-more').html('Show Fewer Brands');*/
            });
            thisElem.find('.toggle-more:contains("Fewer")').on('click', function () {
                thisElem.find("li:gt(" + (InitialListItems - 1) + ")").hide(); // hide all but first N sections
            });

        });
        /*$('div#slidermenu-fbr:contains("All")').live('click',function() {
         $('#facetvalues-fbr li').show(); // hide all but first 2 sections
         $('#slidermenu-fbr').html('Show Fewer Brands');
         });
         $('div#slidermenu-fbr:contains("Fewer")').live('click',function() {
         $("#facetvalues-fbr li:gt("+(InitialListItems-1)+")").hide(); // hide all but first N sections

         }*/
    }

    function swipeEvents() {
        var body = $('body');
        var page = $('.pages .page').first();
        nextPage = page.data('next');
        prevPage = page.data('prev');
        body.on('swipeleft', swipePageLeft);
        body.on('swiperight', swipePageRight);
    }

    function resize(e) {
        extraNavPos = $('#navigation-sticky').offset();
        //delay(1000);
        $.each($('.swimmer-thumb'), function () {
            var cw = $(this).width();
            $(this).css('height', cw + 'px');
        });


        /*if(window.innerWidth < 400 ) {
         console.log('in if');
         $.each($('canvas.chart'), function() {
         setTimeout(function() {
         console.log('change css');
         $(this).css('height', '300px');

         }, 500);
         });
         /* for(var i = 0; i < allCharts.length; i++) {
         allCharts[i].chart().chart.height = 250;
         allCharts[i].chart().update();

         }*/
        /*} else if (window.innerWidth > 600) {
         console.log('elsif');
         console.log($(canvas));
         $('canvas').each(function() {
         $(this).css('height', '100px');
         console.log($(this));
         });
         /* for(var i = 0; i < allCharts.length; i++) {
         allCharts[i].chart().chart.height = 150;
         allCharts[i].chart().update();

         }*/
        //}
        //var cw = $('.swimmer-thumb').width();

        //$('.swimmer-thumb').css({'height': cw + 'px'});
    }

    function swipePageLeft(e) {
        //console.log(e);
        //var nextPage = $(e.currentTarget).data('next');
        //console.log(nextPage);
        var page = $('#' + nextPage);
        page.trigger('click');
        //nextPage = page.data('next');
        //prevPage = page.data('prev');
    }

    function swipePageRight(e) {
        //console.log(e);
        //var nextPage = $(e.currentTarget).data('prev');
        var page = $('#' + prevPage);
        page.trigger('click');
        //nextPage = page.data('next');
        //prevPage = page.data('prev');
    }

    function sort(event, ui) {
        var id = ui.item.data('id');
        var tableClass = ui.item.data('class');
        var position = $('.' + tableClass).index(ui.item);
        var url = $('#' + ui.item.data('table')).data('url');
        $('.sortable').sortable('disable');

        updatePosition(id, position, url);
    }

    function sortStop(event, ui) {
        //console.log(sortStop);
        $('.sortable').sortable('disable');
    }

    function updatePosition(id, position, url) {
        $.post(url, {
            position: position,
            exercise_id: id,
        }, function (data) {
            console.log(data);
        }, "json");
    }

    function formRequest(e) {
        if ($(e.target).data('ajax')) {
            e.preventDefault();
            var form = $(e.target);

            $.post(form[0].action,
                form.serialize(),
                formResponse,
                'json'
            );
        }
    }

    function formResponse(data) {
        switch (data.form) {
            case "contact":
                updateContact(data);
                break;
            case "timer":
                createNewTimer(data);
        }
    }

    function updateContact(data) {
        var elems = $('.contact-data');

        $.each(elems, function (index, value) {
            var elem = $(value);
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
        $.each(forms, function (index, value) {
            var elem = $(value);
            if (elem.data('is_form')) {
                elem.hide();
            } else {
                elem.show();
            }
        })
    }

    function renderImage() {
        var fileReader = new FileReader();

        readURL(this);
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader;
            reader.onload = function (e) {
                //var arrayBufferView = new Uint8Array( this.result );
                //var blob = new Blob( [ arrayBufferView ], { type: "image/jpeg" } );
                var exif = get_exif_data(this.result)

                switch (exif.Orientation) {

                    case 8:
                        ctx.rotate(90 * Math.PI / 180);
                        break;
                    case 3:
                        ctx.rotate(180 * Math.PI / 180);
                        break;
                    case 6:
                        ctx.rotate(-90 * Math.PI / 180);
                        break;


                }
                if ($(input).data('img') == 'start') {
                    $('#image-start').attr('src', e.target.result);
                } else if ($(input).data('img') == 'crop') {
                    $(input).hide();
                    $('#croppingImg').attr('src', e.target.result);
                    $('#pictures').modal();
                    $('.otherinputfield').remove();
                    $('#cropping').append(input);
                    //input->getMimeType();
                    $('#croppingImg').Jcrop({
                        onSelect: updateCoords,
                        aspectRatio: 1,
                        boxWidth: 450,
                        boxHeight: 450,
                    })
                } else {
                    $('#image-end').attr('src', e.target.result);
                }
            };

            function updateCoords(c) {
                // fix crop size: find ratio dividing current per real size
                var ratioW = $('#croppingImg')[0].naturalWidth / $('#croppingImg').width();
                var ratioH = $('#croppingImg')[0].naturalHeight / $('#croppingImg').height();
                //var currentRatio = Math.min(ratioW, ratioH);
                //var currentRatio = ratioW;
                //console.log(currentRatio);
                console.log(ratioH);
                console.log(ratioW);
                console.log(c);
                $('#croppedImg').val($('.upload-image').val());
                $('#x').val(Math.round(c.x));
                $('#y').val(Math.round(c.y));
                $('#w').val(Math.round(c.w));
                $('#h').val(Math.round(c.h));
            };
            /*reader.onloadend = function(e) {
             var exif = EXIF.readFromBinaryFile(new BinaryFile(this.result));


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

    function get_exif_data(image_result) {
        var data = image_result.replace("data:image/jpeg;base64,", "");
        var decoded_data = decode64(data);

        getLongAt = function (iOffset, bBigEndian) {
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

        getSLongAt = function (iOffset, bBigEndian) {
            var iULong = getLongAt(iOffset, bBigEndian);
            if (iULong > 2147483647)
                return iULong - 4294967296;
            else
                return iULong;
        };

        var result = findEXIFinJPEG({
            getByteAt: function (idx) {
                return decoded_data.charCodeAt(idx);
            },
            getLength: function () {
                return decoded_data.length;
            },
            getShortAt: function (iOffset, bBigEndian) {
                var iShort = bBigEndian ?
                (decoded_data.charCodeAt(iOffset) << 8) + decoded_data.charCodeAt(iOffset + 1)
                    : (decoded_data.charCodeAt(iOffset + 1) << 8) + decoded_data.charCodeAt(iOffset)
                if (iShort < 0) iShort += 65536;
                return iShort;
            },
            getStringAt: function (a, b) {
                return decoded_data.substring(a, a + b);
            },
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
            //alert("There were invalid base64 characters in the input text.\n" +
            //"Valid base64 characters are A-Z, a-z, 0-9, '+', '/',and '='\n" +
            //"Expect errors in decoding.");
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
        $('.pages>div').hide();
        showPage = $('.pages>div.' + pageName);
        showPage.show();
        nextPage = showPage.data('next');
        prevPage = showPage.data('prev');
    }

    function createTimers() {
        var elems = $(".stopwatch");
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
                records: false,
                swimmer: false,
                distance: false,
                stroke: false,
                recordsUrl: elem.data('records'),
            };

            stopwatches[i] = new Stopwatch(elems[i], swOptions);
        }
    }

    function createWithRecord($data) {

    }

    function createNewTimer(data) {
        elem = $('#newStopwatch').prepend('<div class="stopwatch row"></div>');
        var swOptions = {
            //stopwatch_id: elem.data('stopwatch_id'),// ? stopwatch_id : 0,
            //user_id: elem.data('user_id'), //||0,
            //swimmer_id: elem.data('swimmer_id'),
            url: data.route,//stopwatch_store, // ||0,
            startClock: 0, // || 0, clock
            lastTime: 0, // || 0, lastTime
            is_paused: true, // ||false, is_paused
            is_base3: false,
            records: data.records,
            swimmer: data.swimmer,
            distance: data.distance,
            stroke: data.stroke,
        };

        new Stopwatch(elem.find('.stopwatch')[0], swOptions);
    }

    function links(e) {
        var toggle = $(e.currentTarget).data('toggle');
        if (toggle && toggle != 'dropdown') {
            e.preventDefault();
            //console.log($('.' + toggle));
            var elems = $('.' + toggle);
            $.each(elems, function (index, value) {
                if ($(value).data('is_form')) {
                    //console.log('show');
                    $(value).show();
                    $(value).find('input')[1].focus();
                } else {
                    //console.log('hide');
                    $(value).hide();
                }
            });
        }
        if (toggle && toggle == 'picture') {
            e.preventDefault();
        }
        var page = $(e.currentTarget).data('load-page');
        if (page) {

            e.preventDefault();
            //alert('yay');
            elem = $('#read-more').find('a');
            elem.find('.spin-icon').show();

            $.getJSON($(e.currentTarget).data('url'), {page: page}, addData);
            $(e.currentTarget).data('load-page', page + 1);
        }

    }

    function addData(data) {
        elem = $('#read-more').find('a');
        if (!data.meta.length) {
            url = elem.data('url');
            page = elem.data('load-page');
            $.getJSON(url, {page: page}, addData);
            elem.data('load-page', page + 1);

            return true;
        }
        elem.find('.spin-icon').hide();

        $.each(data.meta, function () {
            var date = moment(this.date.date).format('DD MMMM');
            $('<li class="time-label"><span class="bg-red">' + date + '</span></li>')
                .insertBefore('#read-more');
            console.log(this);
            $.each(this.item, function () {
                var element = '<li>';
                switch (this.type) {
                    case 'chrono':
                        console.log(this);
                        element += '<i class="fa fa-clock-o bg-blue"></i><div class="timeline-item">' +
                            '<h3 class="timeline-header">' + this.message.distance.distance +
                            ' ' + this.message.distance.stroke.name + '</h3>' +
                            '<div class="timeline-body"><div class="row stopwatch-ui">';
                        $.each(this.message.times, function () {
                            element += '<div class="col-lg-3 col-md-6 col-xs-12">';
                            $.each(this.time_array.arr, function () {
                                element += '<div class="cell">' + this + '</div> ';
                            });
                            element += '</div>';
                        });
                        element += '</div></div></div>';
                        break;
                    case 'heartRate':
                        element += '<i class="fa fa-heart bg-red"></i><div class="timeline-item">' +
                            '<h3 class="timeline-header">Ochtendpols</h3>' +
                            '<div class="timeline-body">' +
                            '55' +
                            '</div>' +
                            '</div></li>';

                        break;
                    case 'data':
                        element += '<i class="fa fa-envelope bg-blue"></i><div class="timeline-item">' +
                            '<h3 class="timeline-header">' + this.user.name + '</h3>' +
                            '<div class="timeline-body">' + this.message;
                        if (this.media && this.media.url) {
                            element += '<hr>';
                            if (this.media.type == 'img') {
                                element += '<img src="' + this.media.url + '">';
                            } else {
                                element += '<video src="' + this.media.url + '">';
                            }
                        }
                        element += '</div>' +
                            '</div></li>';
                        break;
                }

                $(element).insertBefore('#read-more');
            })
        });

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


