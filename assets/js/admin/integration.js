/* global ajaxurl, WCJadlogIntegrationAdminParams */
jQuery( function( $ ) {

	/**
	 * Admin class.
	 *
	 * @type {Object}
	 */
	var WCJadlogIntegrationAdmin = {

		/**
		 * Initialize actions.
		 */
		init: function() {
			$( document.body ).on( 'click', '#woocommerce_jadlog-integration_autofill_empty_database', this.empty_database );
		},

		/**
		 * Empty database.
		 *
		 * @return {String}
		 */
		empty_database: function() {
			if ( ! window.confirm( WCJadlogIntegrationAdminParams.i18n_confirm_message ) ) {
				return;
			}

			$( '#mainform' ).block({
				message: null,
				overlayCSS: {
					background: '#fff',
					opacity: 0.6
				}
			});

			$.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {
					action: 'jadlog_autofill_addresses_empty_database',
					nonce: WCJadlogIntegrationAdminParams.empty_database_nonce
				},
				success: function( response ) {
					window.alert( response.data.message );
					$( '#mainform' ).unblock();
				}
			});
		}
	};

	WCJadlogIntegrationAdmin.init();
});
