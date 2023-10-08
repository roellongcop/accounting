class StackChartWidget {
  series = [];
  categories = [];

  constructor({widgetId, dataUrl, dateRange, userId = 0, additionalScripts}) {
    this.widgetId = widgetId;
    this.dataUrl = dataUrl;
    this.dateRange = dateRange;
    this.userId = userId;
    this.additionalScripts = additionalScripts;
    this.chartEl = document.getElementById(widgetId);
  }

  createChart() {
    this.chartEl.innerHTML = '';
    const options = {
      fill: {opacity: 1},
      // colors : ['#F64E60', '#FFA800', '#1BC5BD'],
      dataLabels: {enabled: false},
      series: this.series,
      chart: {
        type: 'bar',
        stacked: true,
        toolbar: {show: false},
        zoom: {enabled: false}
      },
      plotOptions: {
        bar: {
          horizontal: false,
          distributed: false,
        }
      },
      responsive: [{
        breakpoint: 480,
        options: {
          legend: {
            position: 'bottom',
            offsetX: -10,
            offsetY: 0
          }
        }
      }],
      xaxis: {
        type: 'text',
        categories: this.categories,
      },
      legend: {
        position: 'top',
        offsetX: "100%"
      },
    };

    const chart = new ApexCharts(this.chartEl, options);
    chart.render();
  }

  formatDate(date) {
    return date.toISOString().split('T')[0];
  }

 
  addMonths(date, months) {
    let d = new Date(date);
    d.setMonth(d.getMonth() + months);
    return d;
  }

  changeDateRange(months) {
    const [start, end] = this.dateRange.split(' - ');
    let startDate = new Date(start);
    let endDate = new Date(end);
    
    if (months > 0) {
      // Moving forward
      if (startDate.getMonth() < 6) {
        startDate.setMonth(6);
        startDate.setDate(1);
        endDate.setMonth(11);
        endDate.setDate(31);
      } else {
        startDate.setFullYear(startDate.getFullYear() + 1);
        startDate.setMonth(0);
        startDate.setDate(1);
        endDate.setDate(1);  // Reset the day first
        endDate.setFullYear(startDate.getFullYear());
        endDate.setMonth(5);
        endDate.setDate(30);
      }
    } else {
      // Moving backward
      if (startDate.getMonth() >= 6) {
        startDate.setMonth(0);
        startDate.setDate(1);
        endDate.setDate(1);  // Reset the day first
        endDate.setMonth(5);
        endDate.setDate(30);
      } else {
        startDate.setFullYear(startDate.getFullYear() - 1);
        startDate.setMonth(6);
        startDate.setDate(1);
        endDate.setFullYear(startDate.getFullYear());
        endDate.setMonth(11);
        endDate.setDate(31);
      }
    }

    const newDate = [this.formatDate(startDate), this.formatDate(endDate)].join(' - ');
    this.dateRange = newDate;

    this.fetchData();
  }

  convertDateRange() {
    // Step 1: Split the input string into two separate date strings
    const dates = this.dateRange.split(' - ');
    
    // Step 2: Parse the date strings into JavaScript Date objects
    const startDate = new Date(dates[0]);
    const endDate = new Date(dates[1]);

    // Step 3: Convert the Date objects to the desired format
    // 'en' is the locale for English, you can change it to your preferred locale
    const startFormatted = startDate.toLocaleString('en', { month: 'short', year: 'numeric' });
    const endFormatted = endDate.toLocaleString('en', { month: 'short', year: 'numeric' });

    // Step 4: Combine the formatted strings into the final output
    const result = `${startFormatted} - ${endFormatted}`;
    return result;
  }

  fetchData() {
    const self = this;

    $(`#${self.widgetId}-stack-chart .btn-year`).html(self.convertDateRange());

    KTApp.block(`#${self.widgetId}-stack-chart`);
    $.ajax({
      url: this.dataUrl,
      method: 'post',
      data: {
        date_range: this.dateRange,
        user_id: this.userId,
      },
      dataType: 'json',
      success: function({status, message, result}) {
        KTApp.unblock(`#${self.widgetId}-stack-chart`);
        if (status === 'success') {
          self.series = result.series;
          self.categories = result.categories;
          self.createChart();

          // $(`#${self.widgetId}-stack-chart .btn-year`).html(result.year);
          return
        }
        alert(message);
      },
      error: function({responseText}) {
        KTApp.unblock(`#${self.widgetId}-stack-chart`);
        alert(responseText);
      }
    });
  }

  init() {
    const self = this;
    self.fetchData();

    self.additionalScripts(self);

    $(`#${self.widgetId}-stack-chart .btn-prev`).click(function(e) {
      e.preventDefault();
      self.changeDateRange(-6);
    });

    $(`#${self.widgetId}-stack-chart .btn-next`).click(function(e) {
      e.preventDefault();
      self.changeDateRange(6);
    });

    $(`#${self.widgetId}-stack-chart .btn-year`).click(function(e) {
      e.preventDefault();
    });
  }
}

