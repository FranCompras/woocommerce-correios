<?php
/**
 * Jadlog Internacional shipping method.
 *
 * @package WooCommerce_Jadlog/Classes/Shipping
 * @since   3.0.0
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Internacional shipping method class.
 */
class WC_Jadlog_Shipping_Internacional extends WC_Jadlog_Shipping {

	/**
	 * Service code.
	 * 10 - Internacional.
	 *
	 * @var string
	 */
	protected $code = '10';

	/**
	 * Initialize Internacional.
	 *
	 * @param int $instance_id Shipping zone instance.
	 */
	public function __construct( $instance_id = 0 ) {
		$this->id           = 'jadlog-internacional';
		$this->method_title = __( 'Jadlog Internacional', 'woocommerce-jadlog' );
		$this->more_link    = '';

		parent::__construct( $instance_id );

	}
	
}