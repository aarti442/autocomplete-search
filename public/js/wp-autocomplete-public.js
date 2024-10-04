(function( $ ) {
	'use strict';
	var ajaxurl = my_ajax_object.ajaxurl;
	// Debounce function to limit the rate of AJAX calls

	let ajaxRequest; // Declare a variable to store the current AJAX request

	jQuery(document).on('keyup', '#wp-search-field-1', function (e) {
		jQuery('.wp-search').addClass('loading');
		var search_input = jQuery(this).val().trim();

		// Check if the input is empty or less than 3 characters, hide results, and stop further execution
		if (search_input === "" || search_input.length < 3) {
			jQuery('.ajax-search-result').hide();
			jQuery('.wp-search').removeClass('loading');
			
			// Cancel the ongoing AJAX request if input is not valid
			if (ajaxRequest) {
				ajaxRequest.abort();
			}
			
			return;
		}

		// Cancel the previous AJAX request before making a new one
		if (ajaxRequest) {
			ajaxRequest.abort();
		}

		// Make the AJAX request
		ajaxRequest = jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {'action': 'wp_autocomplete_search', 'search_input': search_input},
			// dataType: 'json', // Uncomment if your response is JSON
			success: function (response) {
				console.log(response);
				jQuery('.ajax-search-result').html(response);
				jQuery('.ajax-search-result').show();
				jQuery('.wp-search').removeClass('loading');
			},
			error: function (xhr, status) {
				if (status !== 'abort') { // Ignore error if the request was aborted
					console.error("AJAX request failed:", status);
					jQuery('.wp-search').removeClass('loading');
				}
			}
		});
	});
 

	

})( jQuery );
