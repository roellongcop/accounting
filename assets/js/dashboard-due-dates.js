"use strict";


var KTCalendarListView = function() {
    return {
        //main function to initiate the module
        init: function() {
            const TODAY = moment().startOf('day').format('YYYY-MM-DD');

            const modalTitle = $('#modal-event .modal-title');
            const modalBody = $('#modal-event .modal-body');
            const btnSave = $('#btn-save-event');
            const btnAdd = $('#btn-add-event');
            const modal = $('#modal-event');

            const calendar = new FullCalendar.Calendar(document.getElementById('kt_calendar'), {
                plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
                isRTL: KTUtil.isRTL(),
                customButtons: {
                    myCustomButton: {
                        text: 'Refresh',
                        click: function() {
                            calendar.refetchEvents();
                        }
                    }
                },
                loading: function(isLoading) {
                    if (isLoading) {
                        KTApp.block('.fc-view-container', {
                            message: 'Loading events...'
                        });
                    } else {
                        KTApp.unblock('.fc-view-container');
                        const customButton = document.querySelector('.fc-myCustomButton-button');
                        if (customButton) customButton.blur();
                    }
                },
                header: {
                    left: 'prev,next today myCustomButton',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                height: 800,
                contentHeight: 750,
                aspectRatio: 3,  // see: https://fullcalendar.io/docs/aspectRatio
                views: {
                    dayGridMonth: { buttonText: 'month' },
                    timeGridWeek: { buttonText: 'week' },
                    timeGridDay: { buttonText: 'day' },
                    listDay: { buttonText: 'list' },
                    listWeek: { buttonText: 'list' }
                },
                defaultView: 'dayGridMonth',
                defaultDate: TODAY,
                // editable: true,
                eventLimit: 5, // allow "more" link when too many events
                navLinks: true,
                events,
                eventClick,
                eventRender
            });
            calendar.render();

            function eventRender(info) {
                var element = $(info.el);
                if (info.event.extendedProps && info.event.extendedProps.description) {
                    if (element.hasClass('fc-day-grid-event')) {
                        element.data('content', info.event.extendedProps.description);
                        element.data('placement', 'top');
                        KTApp.initPopover(element);
                    } else if (element.hasClass('fc-time-grid-event')) {
                        element.find('.fc-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                    } else if (element.find('.fc-list-item-title').length !== 0) {
                        element.find('.fc-list-item-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                    }
                }
            }

            function events(info, successCallback, failureCallback) {
                const startDate = moment(info.startStr).format('YYYY-MM-DD');
                const endDate = moment(info.endStr).format('YYYY-MM-DD');

                $.ajax({
                    url: app.baseUrl + 'event/index',
                    data: {
                        date_range: [startDate, endDate].join(' - ')
                    },
                    method: 'get',
                    dataType: 'json',
                    success: function({status, models}) {
                        if (status === 'success') {
                            successCallback(models);
                        }
                    },
                    error: function(e) {
                        alert(e.responseText);
                    }
                })
            }

            function eventClick(info) {
                KTApp.block('.due-dates-card', {
                    message: 'Loading events...'
                });
                $.ajax({
                    url: app.baseUrl + 'event/view',
                    data: {
                        slug: info.event.extendedProps.slug
                    },
                    method: 'get',
                    dataType: 'json',
                    success: function({status, model, result, can_update}) {
                        KTApp.unblock('.due-dates-card');
                        if (status === 'success') {
                            modalTitle.html(`Event: ${model.title}`);
                            modalBody.html(result);
                            if (can_update) {
                                btnSave.html('Update Event');
                                btnSave.show();
                            }
                            else {
                                btnSave.hide();
                            }
                            $('.kt-selectpicker').selectpicker();
                            modal.modal('show');
                        }
                    },
                    error: function(e) {
                        KTApp.unblock('.due-dates-card');
                        alert(e.responseText);
                    }
                })
            }

            function handleAddEvent(e) {
                e.preventDefault();
                KTApp.block('.due-dates-card', {
                    message: 'Loading form...'
                });
                $.ajax({
                    url: app.baseUrl + 'event/create',
                    dataType: 'json',
                    success: function({status, form}) {
                        KTApp.unblock('.due-dates-card');

                        if (status === 'success') {
                            btnSave.html('Save Event');
                            btnSave.show();
                            modalTitle.html('Add New Event');
                            modalBody.html(form);
                            $('.kt-selectpicker').selectpicker();
                            modal.modal('show');
                        }
                    },
                    error: function(e) {
                        KTApp.unblock('.due-dates-card');
                        alert(e.responseText);
                    }
                })
            }

            function submitForm(e) {
                e.preventDefault();
                const form = $(this);
                KTApp.block('#event-form');
                $.ajax({
                    url: form.attr('action'),
                    data: form.serialize(),
                    method: form.attr('method'),
                    dataType: 'json',
                    success: function({status, model}) {
                        KTApp.unblock('#event-form');

                        if (status === 'success') {
                            calendar.refetchEvents();
                            form[0].reset();
                            form.yiiActiveForm('resetForm');
                            $('.kt-selectpicker').selectpicker('refresh');
                            $('.bootstrap-select').removeClass('is-valid');

                            modal.modal('hide');
                        }
                    },
                    error: function(e) {
                        KTApp.unblock('#event-form');
                        alert(e.responseText);
                    }
                })

                return false;
            }

            function handleSaveButton() {
                const form = $(document).find('#event-form');
                form.submit();
            }


            btnAdd.on('click', handleAddEvent);
            $(document).on('beforeSubmit', '#event-form', submitForm);
            btnSave.on('click', handleSaveButton);
        }
    };
}();

jQuery(document).ready(function() {
    KTCalendarListView.init();
});