<script src="js/jQuery.auto-save-form.js"></script>

<script>
	$(function() {
		var $form = $('form');
		var $formStatusHolder = $('.js-form-status-holder');

		// Enable on all forms
		$form.autoSaveForm();


		// The following triggers confirm to the beforeSend, error and success ajax callbacks.
		$form.on('beforeSave.autoSaveForm', function (ev, $form, xhr) {
			// called before saving the form
			// here you can return false if the form shouldn't be saved
			// eg. because of validation errors.
			

			// Let the user know we are saving
			$formStatusHolder.html('Saving...');
			$formStatusHolder.removeClass('text-danger');
		});

		$form.on('saveError.autoSaveForm', function (ev, $form, jqXHR, textStatus, errorThrown) {
			// The saving failed so tell the user
			$formStatusHolder.html('Saving failed! Please retry later.');
			$formStatusHolder.addClass('text-danger');
		});
		$form.on('saveSuccess.autoSaveForm', function (ev, $form, data, textStatus, jqXHR) {
			// Now show the user we saved and when we did
			var d = new Date();
			$formStatusHolder.html('Saved! Last: ' + d.toLocaleTimeString());
		});
	});


	// To manually trigger a save on the form you can call
	$('#my-form').trigger('save.autoSaveForm');
</script>