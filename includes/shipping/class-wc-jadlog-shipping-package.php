<?php
/**
 * Jadlog Package shipping method.
 *
 * @package WooCommerce_Jadlog/Classes/Shipping
 * @since   3.0.0
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Package shipping method class.
 */
class WC_Jadlog_Shipping_Package extends WC_Jadlog_Shipping {

	/**
	 * Service code.
	 * 3 - Package.
	 *
	 * @var string
	 */
	protected $code = '3';

	/**
	 * Initialize Package.
	 *
	 * @param int $instance_id Shipping zone instance.
	 */
	public function __construct( $instance_id = 0 ) {
		$this->id           = 'jadlog-package';
		$this->method_title = __( 'Jadlog .Package', 'woocommerce-jadlog' );
		$this->more_link    = '';

		parent::__construct( $instance_id );

	}
	
}