<?php
/**
 * Jadlog
 *
 * @package WooCommerce_Jadlog/Classes
 * @since   3.6.0
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WooCommerce Jadlog main class.
 */
class WC_Jadlog {

	/**
	 * Initialize the plugin public actions.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'load_plugin_textdomain' ), -1 );

		// Checks with WooCommerce is installed.
		if ( class_exists( 'WC_Integration' ) ) {
			self::includes();

			if ( is_admin() ) {
				self::admin_includes();
			}

			//add_filter( 'woocommerce_integrations', array( __CLASS__, 'include_integrations' ) );
			add_filter( 'woocommerce_shipping_methods', array( __CLASS__, 'include_methods' ) );
			//add_filter( 'woocommerce_email_classes', array( __CLASS__, 'include_emails' ) );
		} else {
			add_action( 'admin_notices', array( __CLASS__, 'woocommerce_missing_notice' ) );
		}
	}

	/**
	 * Load the plugin text domain for translation.
	 */
	public static function load_plugin_textdomain() {
		load_plugin_textdomain( 'woocommerce-jadlog', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Includes.
	 */
	private static function includes() {
		include_once dirname( __FILE__ ) . '/wc-jadlog-functions.php';
		include_once dirname( __FILE__ ) . '/class-wc-jadlog-install.php';
		include_once dirname( __FILE__ ) . '/class-wc-jadlog-package.php';
		include_once dirname( __FILE__ ) . '/class-wc-jadlog-webservice.php';
//		include_once dirname( __FILE__ ) . '/class-wc-jadlog-webservice-international.php';
//		include_once dirname( __FILE__ ) . '/class-wc-jadlog-autofill-addresses.php';
//		include_once dirname( __FILE__ ) . '/class-wc-jadlog-tracking-history.php';
//		include_once dirname( __FILE__ ) . '/class-wc-jadlog-rest-api.php';

		// Integration.
//		include_once dirname( __FILE__ ) . '/integrations/class-wc-jadlog-integration.php';

		// Shipping methods.
        include_once dirname( __FILE__ ) . '/abstracts/abstract-wc-jadlog-shipping.php';
        foreach ( glob( plugin_dir_path( __FILE__ ) . '/shipping/*.php' ) as $filename ) {
            include_once $filename;
        }

	}

	/**
	 * Admin includes.
	 */
	private static function admin_includes() {
		include_once dirname( __FILE__ ) . '/admin/class-wc-jadlog-admin-orders.php';
	}

//	/**
//	 * Include Jadlog integration to WooCommerce.
//	 *
//	 * @param  array $integrations Default integrations.
//	 *
//	 * @return array
//	 */
//	public static function include_integrations( $integrations ) {
//		$integrations[] = 'WC_Jadlog_Integration';
//
//		return $integrations;
//	}

	/**
	 * Include Jadlog shipping methods to WooCommerce.
	 *
	 * @param  array $methods Default shipping methods.
	 *
	 * @return array
	 */
	public static function include_methods( $methods ) {
		// New methods.
		if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.6.0', '>=' ) ) {

            $methods['jadlog-cargo']         = 'WC_Jadlog_Shipping_Cargo';
            $methods['jadlog-com']           = 'WC_Jadlog_Shipping_Com';
            $methods['jadlog-corporate']     = 'WC_Jadlog_Shipping_Corporate';
            $methods['jadlog-doc']           = 'WC_Jadlog_Shipping_Doc';
            $methods['jadlog-economico']     = 'WC_Jadlog_Shipping_Economico';
            $methods['jadlog-emergencial']   = 'WC_Jadlog_Shipping_Emergencial';
            $methods['jadlog-expresso']      = 'WC_Jadlog_Shipping_Expresso';
            $methods['jadlog-internacional'] = 'WC_Jadlog_Shipping_Internacional';
            $methods['jadlog-package']       = 'WC_Jadlog_Shipping_Package';
            $methods['jadlog-rodoviario']    = 'WC_Jadlog_Shipping_Rodoviario';

		}

		return $methods;
	}

	/**
	 * Include emails.
	 *
	 * @param  array $emails Default emails.
	 *
	 * @return array
	 */
	public static function include_emails( $emails ) {
		if ( ! isset( $emails['WC_Jadlog_Tracking_Email'] ) ) {
			$emails['WC_Jadlog_Tracking_Email'] = include dirname( __FILE__ ) . '/emails/class-wc-jadlog-tracking-email.php';
		}

		return $emails;
	}

	/**
	 * WooCommerce fallback notice.
	 */
	public static function woocommerce_missing_notice() {
		include_once dirname( __FILE__ ) . '/admin/views/html-admin-missing-dependencies.php';
	}

	/**
	 * Get main file.
	 *
	 * @return string
	 */
	public static function get_main_file() {
		return WC_JADLOG_PLUGIN_FILE;
	}

	/**
	 * Get plugin path.
	 *
	 * @return string
	 */
	public static function get_plugin_path() {
		return plugin_dir_path( WC_JADLOG_PLUGIN_FILE );
	}

	/**
	 * Get templates path.
	 *
	 * @return string
	 */
	public static function get_templates_path() {
		return self::get_plugin_path() . 'templates/';
	}
}
