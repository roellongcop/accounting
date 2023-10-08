class PaymentButtonWidget {

	constructor({widgetId}) {
		this.widgetId = widgetId;
	}

	init() {
		const self = this;

		const formId = `#receive-payment-${self.widgetId}`;

		$(formId).on('beforeSubmit', function(e) {

      e.preventDefault();
      const form = $(this);
      KTApp.block(formId);

      $.ajax({
        url: form.attr('action'),
        method: form.attr('method'),
        dataType: 'json',
        data: form.serialize(),
        success: function({status, model}) {
          KTApp.unblock(formId);
        	if (status === 'success') {
          	Swal.fire('Success', 'Payment Received', 'success').then(() => {
          		location.reload();
          	});
          	return;
        	}

          Swal.fire("Error", 'Something went wrong', "error");
        },
        error: function(e) {
          KTApp.unblock(formId);
          Swal.fire("Error", e.responseText, "error");
        }
      });
      return false;
    });


    $(`#payment-button-${self.widgetId} .btn-confirm`).click(function() {
    	$(this).closest('.payment-button-widget').find('form').submit();
    })
	}
}

