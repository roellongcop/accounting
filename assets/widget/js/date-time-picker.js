class DateTimePickerWidget {
    constructor({start, options}) {
        this.start = start;
        this.options = options;
    }
    init() {
       $(`#${this.widgetId}`).datetimepicker(this.options);

        $(`#${this.widgetId} input`).on('input', function() {
            $(this).removeClass('is-invalid');
            $(this).closest('.form-group').find('.help-block').remove();
        });
    }
}