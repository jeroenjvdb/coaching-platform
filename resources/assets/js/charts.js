var ChartConfig = function (elem, data) {
        var timeFormat = 'MM/DD/YYYY';
        //var url = $('.chart').first().data('url');
        console.log(data);
        config(data);
//$.getJSON(url, jsonData);

        function randomScalingFactor() {
            return Math.round(Math.random() * 100 * (Math.random() > 0.5 ? -1 : 1));
        }

        function randomColorFactor() {
            return Math.round(Math.random() * 255);
        }

        function randomColor(opacity) {
            return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',' + (opacity || '.3') + ')';
        }

        function newDate(days) {
            return moment().add(days, 'd').toDate();
        }

        function newDateString(days) {
            return moment(days, 'YYYY-MM-DD h:i:s').format(timeFormat);
        }

        function newTimestamp(days) {
            return moment().add(days, 'd').unix();
        }

        function config(data) {
            var configData;
            if (data.datatype == 'heartRate') {
                configData = heartRate(data);
            } else if (data.datatype == 'distance') {
                configData = distance(data);

            }
            console.log(configData);

            var ctx = elem.getContext("2d");
            window.myLine = new Chart(ctx, configData);
            //ctx.fillText(data.datatype + "%", ctx.canvas.width/2 - 20, ctx.canvas.width/2, 200);
        }


        function distance(data) {
            window.Chart.Doughnut.defaults = {
                labelFontFamily: "Arial",
                labelFontStyle: "normal",
                labelFontSize: 24,
                labelFontColor: "#666"
            };
            configData = [];
            configLabels = [];
            configColor = [];
            console.log(data);
            for (var i = 0; i < data.categories.length; i++) {
                var cat = data.categories[i];

                var configuration = {
                    value: cat.total,
                    color: randomColor(.9),
                };

                configColor.push(randomColor(.9));
                configLabels.push(cat.name);
                configData.push(cat.total);
            }
            console.log(configColor);
            return {
                type: 'doughnut',
                data: {
                    labels: configLabels, //[newDate(0), newDate(1), newDate(2), newDate(3), newDate(4), newDate(5), newDate(6)], // Date Objects

                    datasets: [{
                        label: "pols ",
                        data: configData,
                        backgroundColor: configColor,
                        fill: false,
                    }]
                },
                percentageInnerCutout : 80,
                options: {

                    responsive: true,
                    title: {
                        display: false,
                        fontSize: 24,
                        fontStyle: 'normal',
                        fontColor: 'black',
                        text: "ochtendpolsen"
                    },
                    animation: {
                        onComplete: function () {
                            ctx = elem.getContext('2d');
                            console.log('on anim complete');
                            var canvasWidthvar = $(elem).width();
                            var canvasHeight = $(elem).height();
                            console.log(canvasHeight);
                            //this constant base on canvasHeight / 2.8em
                            var constant = 150;
                            var fontsize = (canvasHeight / constant).toFixed(2);
                            console.log(fontsize)
                            ctx.font = fontsize + "em Verdana";
                            ctx.textBaseline = "middle";
                            var total = 0;
                            $.each(configData, function () {
                                total += parseInt(this.value, 10);
                            });
                            //var tpercentage = ((configData[0]/total)*100).toFixed(2)+"%";
                            var tpercentage = data.training.total + "m";
                            var textWidth = ctx.measureText(tpercentage).width;

                            var txtPosx = Math.round((canvasWidthvar - textWidth) / 2);
                            ctx.fillText(tpercentage, txtPosx, canvasHeight / 2 + 10);

                        }
                    }
                },
                onAnimationComplete: function () {

                }
            };
        }

//,
        //scales: {
//                    yAxes: [{
//                        scaleLabel: {
//                            display: true,
//                            labelString: 'pols'
//                        },
//                        ticks: {
////                            beginAtZero: true,7
//                            suggestedMin: 40,
//                            suggestedMax: 60,
//                            stepsize: 5
//                        },
//                    }],
//                    xAxes: [{
//
//                        type: "time",
//                        time: {
////                        parser: 'DD MMM',
//
//                            format: timeFormat,
////                        unit: 'week',
//                            round: 'day',
//                            tooltipFormat: 'DD MMM'
//                        },
//                        scaleLabel: {
//                            display: false,
//                            labelString: 'Datum'
//                        }
//                    }]
//                }
//            }
//        };
//    }

        function heartRate(data) {
            console.log(data);
            var heartRates = [];
            for (var i = 0; i < data.hr.length; i++) {
                console.log(data.hr[i]);
                for (var i = 0; i < data.hr.length; i++) {
                    var heartRate = {
                        x: newDateString(data.hr[i].created_at),
                        y: data.hr[i].heart_rate,
                    };
                    heartRates.push(heartRate);

                }

            }
            return {
                type: 'line',
                data: {
                    labels: [newDate(0), newDate(1), newDate(2), newDate(3), newDate(4), newDate(5), newDate(6)], // Date Objects
                    datasets: [{
                        label: "pols ",
                        data: heartRates,
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    title: {
                        display: false,
//                    fontSize: 24,
//                    fontStyle: 'normal',
//                    fontColor: 'black',
//                    text:"ochtendpolsen"
                    },
                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'pols'
                            },
                            ticks: {
//                            beginAtZero: true,7
                                suggestedMin: 40,
                                suggestedMax: 60,
                                stepsize: 5
                            },
                        }],
                        xAxes: [{
                            type: "time",
                            time: {
//                        parser: 'DD MMM',

                                format: timeFormat,
//                        unit: 'week',
                                round: 'day',
                                tooltipFormat: 'DD MMM'
                            },
                            scaleLabel: {
                                display: false,
                                labelString: 'Datum'
                            }
                        }]
                    }
                }
            }
        }
    }
    ;


//    console.log();


//    var heartRates = [];
//for (var i = 0; i < HR.length; i++) {
//    console.log(HR[i]);
//    for (var i = 0; i < HR.length; i++) {
////            console.log(HR[i]);
//        var heartRate = {
//            x: newDateString(HR[i].x.date),
//            y: HR[i].y,
//        }
//        heartRates.push(heartRate);
//
//    }
//
//}

//function jsonData(data) {
//    config(data)
//}


//$.each(config.data.datasets, function (i, dataset) {
//    dataset.borderColor = randomColor(0.4);
//    dataset.backgroundColor = randomColor(0.5);
//    dataset.pointBorderColor = randomColor(0.7);
//    dataset.pointBackgroundColor = randomColor(0.5);
//    dataset.pointBorderWidth = 1;
//});


//$('#randomizeData').click(function () {
//    $.each(config.data.datasets, function (i, dataset) {
//        $.each(dataset.data, function (j, dataObj) {
//            if (typeof dataObj === 'object') {
//                dataObj.y = randomScalingFactor();
//            } else {
//                dataset.data[j] = randomScalingFactor();
//            }
//        });
//    });
//    window.myLine.update();
//});
//$('#addDataset').click(function () {
//    var newDataset = {
//        label: 'Dataset ' + config.data.datasets.length,
//        borderColor: randomColor(0.4),
//        backgroundColor: randomColor(0.5),
//        pointBorderColor: randomColor(0.7),
//        pointBackgroundColor: randomColor(0.5),
//        pointBorderWidth: 1,
//        data: [],
//    };
//    for (var index = 0; index < config.data.labels.length; ++index) {
//        newDataset.data.push(randomScalingFactor());
//    }
//    config.data.datasets.push(newDataset);
//    window.myLine.update();
//});
//$('#addData').click(function () {
//    if (config.data.datasets.length > 0) {
//        config.data.labels.push(newDate(config.data.labels.length));
//        for (var index = 0; index < config.data.datasets.length; ++index) {
//            if (typeof config.data.datasets[index].data[0] === "object") {
//                config.data.datasets[index].data.push({
//                    x: newDate(config.data.datasets[index].data.length),
//                    y: randomScalingFactor(),
//                });
//            } else {
//                config.data.datasets[index].data.push(randomScalingFactor());
//            }
//        }
//        window.myLine.update();
//    }
//});
//$('#removeDataset').click(function () {
//    config.data.datasets.splice(0, 1);
//    window.myLine.update();
//});
//$('#removeData').click(function () {
//    config.data.labels.splice(-1, 1); // remove the label first
//    config.data.datasets.forEach(function (dataset, datasetIndex) {
//        dataset.data.pop();
//    });
//    window.myLine.update();
//});
