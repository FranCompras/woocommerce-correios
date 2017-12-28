<?php
/**
 * Jadlog Econômico shipping method.
 *
 * @package WooCommerce_Jadlog/Classes/Shipping
 * @since   3.0.0
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Econômico shipping method class.
 */
class WC_Jadlog_Shipping_Economico extends WC_Jadlog_Shipping {

	/**
	 * Service code.
	 * 5 - Econômico.
	 *
	 * @var string
	 */
	protected $code = '5';

	/**
	 * Initialize Econômico.
	 *
	 * @param int $instance_id Shipping zone instance.
	 */
	public function __construct( $instance_id = 0 ) {
		$this->id           = 'jadlog-economico';
		$this->method_title = __( 'Jadlog Econômico', 'woocommerce-jadlog' );
		$this->more_link    = '';

		parent::__construct( $instance_id );

	}

    /**
     * Get the declared value from the package.
     *
     * @param  array $package Cart package.
     * @return float
     */
    protected function get_declared_value( $package ) {
        if ( 18 >= $package['contents_cost'] ) {
            return 0;
        }

        return $package['contents_cost'];
    }

}