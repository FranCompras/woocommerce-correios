/* global wp, ajaxurl, WCJadlogAdminOrdersParams */
jQuery( function( $ ) {

	/**
	 * Admin class.
	 *
	 * @type {Object}
	 */
	var WCJadlogAdminOrders = {

		/**
		 * Initialize actions.
		 */
		init: function() {
			$( document.body )
				.on( 'click', '.jadlog-tracking-code .dashicons-dismiss', this.removeTrackingCode )
				.on( 'click', '.jadlog-tracking-code .button-secondary', this.addTrackingCode );
		},

		/**
		 * Block meta boxes.
		 */
		block: function() {
			$( '#wc_jadlog' ).block({
				message: null,
				overlayCSS: {
					background: '#fff',
					opacity: 0.6
				}
			});
		},

		/**
		 * Unblock meta boxes.
		 */
		unblock: function() {
			$( '#wc_jadlog' ).unblock();
		},

		/**
		 * Add tracking fields.
		 *
		 * @param {Object} $el Current element.
		 */
		addTrackingFields: function( trackingCodes ) {
			var $wrap = $( 'body #wc_jadlog .jadlog-tracking-code' );
			var template = wp.template( 'tracking-code-list' );

			$( '.jadlog-tracking-code__list', $wrap ).remove();
			$wrap.prepend( template( { 'trackingCodes': trackingCodes } ) );
		},

		/**
		 * Add tracking code.
		 *
		 * @param {Object} evt Current event.
		 */
		addTrackingCode: function( evt ) {
			evt.preventDefault();

			var $el          = $( '#add-tracking-code' );
			var trackingCode = $el.val();

			if ( '' === trackingCode ) {
				return;
			}

			var self = WCJadlogAdminOrders;
			var data = {
				action: 'woocommerce_jadlog_add_tracking_code',
				security: WCJadlogAdminOrdersParams.nonces.add,
				order_id: WCJadlogAdminOrdersParams.order_id,
				tracking_code: trackingCode
			};

			self.block();

			// Clean input.
			$el.val( '' );

			// Add tracking code.
			$.ajax({
				type: 'POST',
				url: ajaxurl,
				data: data,
				success: function( response ) {
					self.addTrackingFields( response.data );
					self.unblock();
				}
			});
		},

		/**
		 * Remove tracking fields.
		 *
		 * @param {Object} $el Current element.
		 */
		removeTrackingFields: function( $el ) {
			var $wrap = $( 'body #wc_jadlog .jadlog-tracking-code__list' );

			if ( 1 === $( 'li', $wrap ).length ) {
				$wrap.remove();
			} else {
				$el.closest( 'li' ).remove();
			}
		},

		/**
		 * Remove tracking code.
		 *
		 * @param {Object} evt Current event.
		 */
		removeTrackingCode: function( evt ) {
			evt.preventDefault();

			// Ask if really want remove the tracking code.
			if ( ! window.confirm( WCJadlogAdminOrdersParams.i18n.removeQuestion ) ) {
				return;
			}

			var self = WCJadlogAdminOrders;
			var $el  = $( this );
			var data = {
				action: 'woocommerce_jadlog_remove_tracking_code',
				security: WCJadlogAdminOrdersParams.nonces.remove,
				order_id: WCJadlogAdminOrdersParams.order_id,
				tracking_code: $el.data( 'code' )
			};

			self.block();

			// Remove tracking code.
			$.ajax({
				type: 'POST',
				url: ajaxurl,
				data: data,
				success: function() {
					self.removeTrackingFields( $el );
					self.unblock();
				}
			});
		}
	};

	WCJadlogAdminOrders.init();
});
