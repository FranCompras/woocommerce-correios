<?php
/**
 * Jadlog Rodoviario shipping method.
 *
 * @package WooCommerce_Jadlog/Classes/Shipping
 * @since   3.0.0
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Rodoviario shipping method class.
 */
class WC_Jadlog_Shipping_Rodoviario extends WC_Jadlog_Shipping {

	/**
	 * Service code.
	 * 4 - Rodoviario.
	 *
	 * @var string
	 */
	protected $code = '4';

	/**
	 * Initialize Rodoviario.
	 *
	 * @param int $instance_id Shipping zone instance.
	 */
	public function __construct( $instance_id = 0 ) {
		$this->id           = 'jadlog-rodoviario';
		$this->method_title = __( 'Jadlog Rodoviario', 'woocommerce-jadlog' );
		$this->more_link    = '';

		parent::__construct( $instance_id );

	}
	
}