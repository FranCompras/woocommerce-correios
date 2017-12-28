jQuery( function( $ ) {

	/**
	 * Admin class.
	 *
	 * @type {Object}
	 */
	var WCJadlogOpenTrackingCode = {

		/**
		 * Initialize actions.
		 */
		init: function() {
			$( document.body )
				.on( 'click', '.jadlog-tracking-code a', this.openTrackingLink );
		},

		/**
		 * Open tracking link into Jadlog.
		 *
		 * @param {Object} evt Current event.
		 */
		openTrackingLink: function( evt ) {
			evt.preventDefault();

			// Remove old form.
			$( '#wc-jadlog-tracking__form' ).remove();

			var code  = $( this ).text();
			var form = '<form id="wc-jadlog-tracking__form" method="post" action="https://www.jadlog.com.br/sitejadlog/tracking.jad" target="_blank" rel="nofollow noopener noreferrer" style="display: none;">';
			form += '<input type="hidden" name="objetos" value="' + code + '" />';
			form += '</form>';

			$( 'body' ).prepend( form );

			// Submit form.
			$( '#wc-jadlog-tracking__form' ).submit();
		}
	};

	WCJadlogOpenTrackingCode.init();
});
