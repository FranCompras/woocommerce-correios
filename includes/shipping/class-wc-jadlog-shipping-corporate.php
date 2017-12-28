<?php
/**
 * Jadlog Corporate shipping method.
 *
 * @package WooCommerce_Jadlog/Classes/Shipping
 * @since   3.0.0
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Corporate shipping method class.
 */
class WC_Jadlog_Shipping_Corporate extends WC_Jadlog_Shipping {

	/**
	 * Service code.
	 * 7 - Corporate.
	 *
	 * @var string
	 */
	protected $code = '7';

	/**
	 * Initialize Corporate.
	 *
	 * @param int $instance_id Shipping zone instance.
	 */
	public function __construct( $instance_id = 0 ) {
		$this->id           = 'jadlog-corporate';
		$this->method_title = __( 'Jadlog Corporate', 'woocommerce-jadlog' );
		$this->more_link    = '';

		parent::__construct( $instance_id );

	}
}