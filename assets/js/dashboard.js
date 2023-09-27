 function createChart(data) {
    var chart = AmCharts.makeChart("cashflow-chart", {
        "rtl": KTUtil.isRTL(),
        "type": "serial",
        "addClassNames": true,
        "theme": "light",
        "autoMargins": true,
        "balloon": {
            "adjustBorderColor": false,
            "horizontalPadding": 10,
            "verticalPadding": 8,
            "color": "#ffffff"
        },
        "dataProvider": data,
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
        "categoryField": "label",
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

function fetchData(post) {
    KTApp.block('.cashflow-card');
    $.ajax({
        url: app.baseUrl + 'dashboard/filter-cash-flow',
        method: 'post',
        data: post,
        dataType: 'json',
        success: function({status, data, message}) {
            KTApp.unblock('.cashflow-card');
            if (status === 'success') return createChart(data);
            alert(message);
        },
        error: function({responseText}) {
            KTApp.unblock('.cashflow-card');
            alert(responseText);
        }
    })
}

$('#cashflow-user_id').change(function() {
    const userId = $(this).val();
    const dateRange = $('.date-range-search input[name="date_range"]').val();
    fetchData({
        dateRange,
        userId,
    })
});

function initData(dateRange) {
    const userId = $('#cashflow-user_id').val();
    fetchData({
        dateRange,
        userId,
    })
}