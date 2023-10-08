const primary = '#6993FF';
const success = '#1BC5BD';
const info = '#8950FC';
const warning = '#FFA800';
const danger = '#F64E60';

function createChart(result) {
  const cashFlow = document.getElementById("cashflow-chart");
  const totalIncome = document.getElementById("total-income");
  const totalExpense = document.getElementById("total-expense");
  const totalBalance = document.getElementById("total-balance");
  const totalBalanceLabel = document.getElementById("total-balance-label");

  function formatNumber(val) {
    // Convert the number to a string with at most two decimal places.
    let str = parseFloat(val).toFixed(2);

    // Check if it's an integer value (ends with ".00")
    if (str.endsWith('.00')) {
      str = str.substring(0, str.length - 3);
    }

    // Add commas as thousand separators
    const parts = str.split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    return parts.join(".");
  }

  if (result.records.length === 0) {
    cashFlow.innerHTML = `
      <div class="align-items-center d-flex justify-content-center" style="height:inherit">
        <p class="lead font-weight-bold">No data found</p>
      </div>
    `;

    totalIncome.innerHTML = 0;
    totalExpense.innerHTML = 0;
    totalBalance.innerHTML = 0;
    totalBalanceLabel.innerHTML = 'Balance';
    return;
  }

  totalIncome.innerHTML = formatNumber(result.total_income);
  totalExpense.innerHTML = formatNumber(result.total_expense);
  totalBalance.innerHTML = "<span class='"+ result.total_balance_class +"'>"+ formatNumber(result.total_balance)+"</span>";
  totalBalanceLabel.innerHTML = result.total_balance_label;
          

  cashFlow.innerHTML = '';
  const apexChart = "#cashflow-chart";
  const options = {
    series: result.data,
    chart: {
      type: 'bar',
      height: 350
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: '55%',
        // endingShape: 'rounded'
      },
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      show: true,
      width: 2,
      colors: ['transparent']
    },
    xaxis: {
      categories: result.label,
    },
    yaxis: {
      title: {
        text: 'Amount'
      }
    },
    fill: {
      opacity: 1
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return formatNumber(val);
        }
      }
    },
    colors: [success, danger]
  };

  const chart = new ApexCharts(document.querySelector(apexChart), options);
  chart.render();
}

function fetchData(post) {
  KTApp.block('.cashflow-card');
  $.ajax({
    url: app.baseUrl + 'dashboard/filter-cash-flow',
    method: 'post',
    data: post,
    dataType: 'json',
    success: function({status, message, result}) {
      KTApp.unblock('.cashflow-card');
      if (status === 'success') return createChart(result);
      alert(message);
    },
    error: function({responseText}) {
      KTApp.unblock('.cashflow-card');
      alert(responseText);
    }
  });
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