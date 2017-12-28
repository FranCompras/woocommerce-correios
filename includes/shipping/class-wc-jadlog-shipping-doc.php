<?php
/**
 * Jadlog Doc shipping method.
 *
 * @package WooCommerce_Jadlog/Classes/Shipping
 * @since   3.0.0
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Doc shipping method class.
 */
class WC_Jadlog_Shipping_Doc extends WC_Jadlog_Shipping {

	/**
	 * Service code.
	 * 6 - Doc.
	 *
	 * @var string
	 */
	protected $code = '6';

	/**
	 * Initialize Doc.
	 *
	 * @param int $instance_id Shipping zone instance.
	 */
	public function __construct( $instance_id = 0 ) {
		$this->id           = 'jadlog-doc';
		$this->method_title = __( 'Jadlog Doc', 'woocommerce-jadlog' );
		$this->more_link    = '';

		parent::__construct( $instance_id );

	}

}