class ReminderWidget {

    constructor({widgetId}) {
        this.widgetId = widgetId;
    }

    init() {
        let self = this;
        $(`#${self.widgetId} .close-alert`).click(function() {
            $(this).closest('.app-alert').remove();
        });
    }
}

