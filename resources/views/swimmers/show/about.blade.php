<h2>about</h2>
<a href="#"><i class="fa fa-pencil" aria-hidden="true"></i></a>
<h3>aanwezigheden</h3>
<div class="progress">
    <div class="progress-bar" role="progressbar" aria-valuenow="{{ $swimmer->presence * 100 }}%"
         aria-valuemin="0" aria-valuemax="100" style="width: {{ $swimmer->presence * 100 }}%">
        {{ $swimmer->presence * 100 }}%
    </div>
</div>

<canvas id="canvas" class="chart" data-url="/me/heartRate" width="800" height="400"></canvas>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.2/Chart.min.js"></script>
<script>
    var timeFormat = 'MM/DD/YYYY';

    var url = $('.chart').first().data('url');
    console.log(url);
    $.getJSON(url, jsonData);

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

    //    console.log();



    var heartRates = [];
    for(var i = 0; i < HR.length; i++) {
        console.log(HR[i]);
        for(var i = 0; i < HR.length; i++) {
//            console.log(HR[i]);
            var heartRate = {
                x: newDateString(HR[i].x.date),
                y: HR[i].y,
            }
            heartRates.push(heartRate);

        }

    }

    function jsonData(data)
    {
        config(data)
    }




    function config(data)
    {
        var heartRates = [];
        for(var i = 0; i < data.hr.length; i++) {
            console.log(data.hr[i]);
            for(var i = 0; i < data.hr.length; i++) {
                var heartRate = {
                    x: newDateString(data.hr[i].x.date),
                    y: data.hr[i].y,
                }
                heartRates.push(heartRate);

            }

        }
        var config = {
            type: 'line',
            data: {
                labels: [newDate(0), newDate(1), newDate(2), newDate(3), newDate(4), newDate(5), newDate(6)], // Date Objects
                datasets: [{
                    label: "pols ",
                    data: heartRates,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                title:{
                    display:true,
                    fontSize: 24,
                    fontStyle: 'normal',
                    fontColor: 'black',
                    text:"ochtendpolsen"
                },
                scales: {
                    yAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'pols'
                        },
                        ticks : {
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
                            display: true,
                            labelString: 'Datum'
                        }
                    }, ]
                },
            }
        };
        $.each(config.data.datasets, function(i, dataset) {
            dataset.borderColor = randomColor(0.4);
            dataset.backgroundColor = randomColor(0.5);
            dataset.pointBorderColor = randomColor(0.7);
            dataset.pointBackgroundColor = randomColor(0.5);
            dataset.pointBorderWidth = 1;
        });

            var ctx = document.getElementById("canvas").getContext("2d");
            window.myLine = new Chart(ctx, config);

        $('#randomizeData').click(function() {
            $.each(config.data.datasets, function(i, dataset) {
                $.each(dataset.data, function(j, dataObj) {
                    if (typeof dataObj === 'object') {
                        dataObj.y = randomScalingFactor();
                    } else {
                        dataset.data[j] = randomScalingFactor();
                    }
                });
            });
            window.myLine.update();
        });
        $('#addDataset').click(function() {
            var newDataset = {
                label: 'Dataset ' + config.data.datasets.length,
                borderColor: randomColor(0.4),
                backgroundColor: randomColor(0.5),
                pointBorderColor: randomColor(0.7),
                pointBackgroundColor: randomColor(0.5),
                pointBorderWidth: 1,
                data: [],
            };
            for (var index = 0; index < config.data.labels.length; ++index) {
                newDataset.data.push(randomScalingFactor());
            }
            config.data.datasets.push(newDataset);
            window.myLine.update();
        });
        $('#addData').click(function() {
            if (config.data.datasets.length > 0) {
                config.data.labels.push(newDate(config.data.labels.length));
                for (var index = 0; index < config.data.datasets.length; ++index) {
                    if (typeof config.data.datasets[index].data[0] === "object") {
                        config.data.datasets[index].data.push({
                            x: newDate(config.data.datasets[index].data.length),
                            y: randomScalingFactor(),
                        });
                    } else {
                        config.data.datasets[index].data.push(randomScalingFactor());
                    }
                }
                window.myLine.update();
            }
        });
        $('#removeDataset').click(function() {
            config.data.datasets.splice(0, 1);
            window.myLine.update();
        });
        $('#removeData').click(function() {
            config.data.labels.splice(-1, 1); // remove the label first
            config.data.datasets.forEach(function(dataset, datasetIndex) {
                dataset.data.pop();
            });
            window.myLine.update();
        });
    }
</script>