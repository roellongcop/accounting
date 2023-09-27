class DateRangeWidget {
    newRanges = {};

    constructor({ start, end, all_start, all_end, ranges, widgetId, onChange }) {
        this.start = start;
        this.end = end;
        this.all_start = all_start;
        this.all_end = all_end;
        this.ranges = ranges;
        this.widgetId = widgetId;
        this.onChange = onChange;
    }

    init() {
        const self = this;
        const start = moment(this.start);
        const end = moment(this.end);
        const span = $(`#${this.widgetId} span`);
        const input = $(`#${this.widgetId} input`);

        const defaultRanges = {
            'All': [moment(this.all_start), moment(this.all_end)],
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'This Year': [moment().startOf('year'), moment().endOf('year')],
            'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
        }
        for(let key in this.ranges) {
            this.newRanges[this.ranges[key]] = defaultRanges[this.ranges[key]];
        }
        $(`#${this.widgetId}`).daterangepicker({
            // buttonClasses: 'btn btn-sm',
            applyClass: 'btn-primary',
            cancelClass: 'btn-secondary',
            startDate: start,
            endDate: end,
            ranges: this.newRanges
        }, function(start, end, label) {
            const spanValue = start.format('MMMM DD, YYYY') + ' - ' + end.format('MMMM DD, YYYY');
            const inputValue = start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD');

            span.html(spanValue);
            input.val(inputValue);
            self.onChange({start, end, label, inputValue})
        });
        span.html( start.format('MMMM DD, YYYY') + ' - ' + end.format('MMMM DD, YYYY'));
        input.val( start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
    }
}

