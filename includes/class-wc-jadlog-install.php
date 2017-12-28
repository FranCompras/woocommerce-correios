<?php
/**
 * Jadlog integration with the REST API.
 *
 * @package WooCommerce_Jadlog/Classes
 * @since   3.0.0
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * WC_Jadlog_REST_API class.
 */
class WC_Jadlog_Install {

	/**
	 * Get version.
	 *
	 * @return string
	 */
	private static function get_version() {
		return get_option( 'woocommerce_jadlog_version' );
	}

}
