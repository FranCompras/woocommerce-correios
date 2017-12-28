<?php
/**
 * List table - Tracking Code
 *
 * @package WooCommerce_Jadlog/Admin/Settings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="jadlog-tracking-code">
	<small class="meta">
		<?php echo esc_html( _n( 'Tracking code:', 'Tracking codes:', count( $tracking_codes ), 'woocommerce-jadlog' ) ); ?>
		<?php echo implode( ' | ', $tracking_codes ); ?>
	</small>
</div>
