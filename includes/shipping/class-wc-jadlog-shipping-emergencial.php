<?php
/**
 * Jadlog Emergêncial shipping method.
 *
 * @package WooCommerce_Jadlog/Classes/Shipping
 * @since   3.0.0
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Emergêncial shipping method class.
 */
class WC_Jadlog_Shipping_Emergencial extends WC_Jadlog_Shipping {

	/**
	 * Service code.
	 * 14 - Emergêncial.
	 *
	 * @var string
	 */
	protected $code = '14';

	/**
	 * Initialize Emergêncial.
	 *
	 * @param int $instance_id Shipping zone instance.
	 */
	public function __construct( $instance_id = 0 ) {
		$this->id           = 'jadlog-emergencial';
		$this->method_title = __( 'Jadlog Emergêncial', 'woocommerce-jadlog' );
		$this->more_link    = '';

		parent::__construct( $instance_id );

	}
	
}