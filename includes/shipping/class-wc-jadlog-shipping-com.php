<?php
/**
 * Jadlog .COM shipping method.
 *
 * @package WooCommerce_Jadlog/Classes/Shipping
 * @since   3.0.0
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * .COM shipping method class.
 */
class WC_Jadlog_Shipping_Com extends WC_Jadlog_Shipping {

	/**
	 * Service code.
	 * 9 - .Com.
	 *
	 * @var string
	 */
	protected $code = '9';

	/**
	 * Initialize .Com.
	 *
	 * @param int $instance_id Shipping zone instance.
	 */
	public function __construct( $instance_id = 0 ) {
		$this->id           = 'jadlog-com';
		$this->method_title = __( 'Jadlog .Com', 'woocommerce-jadlog' );
		$this->more_link    = '';

		parent::__construct( $instance_id );

	}
}