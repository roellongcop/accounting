class DateRangeWidget {
    newRanges = {};

    constructor({ start, end, all_start, all_end, ranges, widgetId, onChange, time_picker }) {
        this.start = start;
        this.end = end;
        this.all_start = all_start;
        this.all_end = all_end;
        this.ranges = ranges;
        this.widgetId = widgetId;
        this.onChange = onChange;
        this.time_picker = time_picker;
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

        const spanFormat = this.time_picker ? 'MMMM DD, YYYY h:mm A': 'MMMM DD, YYYY';
        const valueFormat = this.time_picker ? 'YYYY-MM-DD h:mm A': 'YYYY-MM-DD';

        const options = {
            // buttonClasses: 'btn btn-sm',
            applyClass: 'btn-primary',
            cancelClass: 'btn-secondary',
            startDate: start,
            endDate: end,
            timePicker: this.time_picker,
        }
        if (JSON.stringify(this.newRanges) !== '{}') options.ranges = this.newRanges;
        if (this.time_picker) options.locale = {format: 'MM/DD/YYYY h:mm A'};

        $(`#${this.widgetId}`).daterangepicker(options, (start, end, label) => {

            const spanValue = [start.format(spanFormat), end.format(spanFormat)].join(' - ');
            const inputValue = [start.format(valueFormat), end.format(valueFormat)].join(' - ');

            span.html(spanValue);
            input.val(inputValue);
            self.onChange({start, end, label, inputValue})
        });
        span.html([start.format(spanFormat), end.format(spanFormat)].join(' - '));
        input.val([start.format(valueFormat), end.format(valueFormat)].join(' - '));
    }
}

