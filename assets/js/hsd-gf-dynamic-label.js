( function( $ ) {
	$( document ).on( 'gform_post_render', function( event, formId ) {
		var config = window.hsdDynamicDisplayName;

		if ( ! config || parseInt( config.formId, 10 ) !== parseInt( formId, 10 ) ) {
			return;
		}

		var roleSelector = '#input_' + config.formId + '_' + config.roleFieldId;
		var nameField = $( '#field_' + config.formId + '_' + config.nameFieldId );

		if ( ! nameField.length ) {
			return;
		}

		function applyLabel( value ) {
			var settings = config.labels && config.labels[ value ] ? config.labels[ value ] : {
				label: config.defaultLabel,
				description: config.defaultMessage,
			};
			var descriptionElement = nameField.find( '.gfield_description' );

			nameField.find( '.gfield_label' ).text( settings.label || '' );

			if ( descriptionElement.length ) {
				descriptionElement.text( settings.description || '' );
			} else if ( settings.description ) {
				descriptionElement = $( '<div>', { 'class': 'gfield_description' } );
				descriptionElement.text( settings.description );
				nameField.append( descriptionElement );
			}
		}

		applyLabel( $( roleSelector + ':checked' ).val() );

		$( document ).on( 'change', roleSelector, function() {
			applyLabel( $( this ).val() );
		} );
	} );
}( jQuery ) );

