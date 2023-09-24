<?php
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dashboard';
$this->params['searchModel'] = $searchModel; 
$this->params['wrapCard'] = false;

$this->addCssFile('amcharts/lib/3/plugins/export/export');

$this->addJsFile('amcharts/lib/3/amcharts');
$this->addJsFile('amcharts/lib/3/serial');

$this->addJsFile('amcharts/lib/3/plugins/animate/animate.min');
$this->addJsFile('amcharts/lib/3/plugins/export/export.min');
$this->addJsFile('amcharts/lib/3/themes/light');


$this->registerJs(<<< JS
    
    // AmCharts.makeChart("kt_amcharts_3", options);
    var KTamChartsChartsDemo = function() {
        var options = {
            "rtl": KTUtil.isRTL(),
            "type": "serial",
            "theme": "light",
            "dataProvider": [{
                "country": "January",
                "visits": 2025
            }, {
                "country": "February",
                "visits": 1882
            }, {
                "country": "March",
                "visits": 1809
            }, {
                "country": "April",
                "visits": 1322
            }, {
                "country": "May",
                "visits": 1122
            }, {
                "country": "June",
                "visits": 1114
            }, {
                "country": "July",
                "visits": 984
            }, {
                "country": "August",
                "visits": 711
            }, {
                "country": "September",
                "visits": 665
            }, {
                "country": "October",
                "visits": 580
            }, {
                "country": "November",
                "visits": 443
            }, {
                "country": "December",
                "visits": 441
            }],
            "valueAxes": [{
                "gridColor": "#FFFFFF",
                "gridAlpha": 0.2,
                "dashLength": 0
            }],
            "gridAboveGraphs": true,
            "startDuration": 1,
            "graphs": [{
                "balloonText": "[[category]]: <b>[[value]]</b>",
                "fillAlphas": 0.8,
                "lineAlpha": 0.2,
                "type": "column",
                "valueField": "visits"
            }],
            "chartCursor": {
                "categoryBalloonEnabled": false,
                "cursorAlpha": 0,
                "zoomable": false
            },
            "categoryField": "country",
            "categoryAxis": {
                "gridPosition": "start",
                "gridAlpha": 0,
                "tickPosition": "start",
                "tickLength": 20
            },
            "export": {
                "enabled": true
            }
        }
        var demo1 = function() {
            var chart1 = AmCharts.makeChart("kt_amcharts_1", options);
        }
        var demo2 = function() {
            var chart = AmCharts.makeChart("kt_amcharts_2", {
                "rtl": KTUtil.isRTL(),
                "type": "serial",
                "addClassNames": true,
                "theme": "light",
                "autoMargins": false,
                "marginLeft": 30,
                "marginRight": 8,
                "marginTop": 10,
                "marginBottom": 26,
                "balloon": {
                    "adjustBorderColor": false,
                    "horizontalPadding": 10,
                    "verticalPadding": 8,
                    "color": "#ffffff"
                },

                "dataProvider": [{
                    "year": 'January',
                    "income": 23.5,
                    "expenses": 21.1
                }, {
                    "year": 'February',
                    "income": 26.2,
                    "expenses": 30.5
                }, {
                    "year": 'March',
                    "income": 30.1,
                    "expenses": 34.9
                }, {
                    "year": 'April',
                    "income": 29.5,
                    "expenses": 31.1
                }, {
                    "year": 'May',
                    "income": 30.6,
                    "expenses": 28.2,
                    "dashLengthLine": 5
                }, {
                    "year": 'June',
                    "income": 34.1,
                    "expenses": 32.9,
                    "dashLengthLine": 5,
                    // "alpha": 0.2,
                    // "additional": "(projection)"
                },{
                    "year": 'July',
                    "income": 23.5,
                    "expenses": 21.1,
                    "dashLengthLine": 5
                }, {
                    "year": 'August',
                    "income": 26.2,
                    "expenses": 30.5,
                    "dashLengthLine": 5
                }, {
                    "year": 'September',
                    "income": 30.1,
                    "expenses": 34.9,
                    "dashLengthLine": 5
                }, {
                    "year": 'October',
                    "income": 29.5,
                    "expenses": 31.1,
                    "dashLengthLine": 5
                }, {
                    "year": 'November',
                    "income": 30.6,
                    "expenses": 28.2,
                    "dashLengthLine": 5,
                }, {
                    "year": 'December',
                    "income": 34.1,
                    "expenses": 32.9,
                    "dashLengthLine": 5,
                    // "alpha": 0.2,
                    // "additional": "(projection)"
                }],
                "valueAxes": [{
                    "axisAlpha": 0,
                    "position": "left"
                }],
                "startDuration": 1,
                "graphs": [{
                    "alphaField": "alpha",
                    "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                    "fillAlphas": 1,
                    "title": "Income",
                    "type": "column",
                    "valueField": "income",
                    "dashLengthField": "dashLengthColumn"
                }, {
                    "id": "graph2",
                    "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                    "bullet": "round",
                    "lineThickness": 3,
                    "bulletSize": 7,
                    "bulletBorderAlpha": 1,
                    "bulletColor": "#FFFFFF",
                    "useLineColorForBulletBorder": true,
                    "bulletBorderThickness": 3,
                    "fillAlphas": 0,
                    "lineAlpha": 1,
                    "title": "Expenses",
                    "valueField": "expenses",
                    // "dashLengthField": "dashLengthLine"
                }],
                "categoryField": "year",
                "categoryAxis": {
                    "gridPosition": "start",
                    "axisAlpha": 0,
                    "tickLength": 0
                },
                "export": {
                    "enabled": true
                }
            });
        }

        return {
        // public functions
        init: function() {
            demo1();
            demo2();
        }
    };
    }();

    KTamChartsChartsDemo.init();
JS)

?>
<div class="dashboard-page">
    <div class="row">

        <div class="col-md-12">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Income/Expense Trend</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div id="kt_amcharts_2" style="height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="row">
        <div class="col-md-12">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Tax Due Dates</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div id="kt_amcharts_1" style="height: 500px;"></div>
                </div>
            </div>
        </div>
    </div> -->
</div>