<?php
/**
 * Tracking history table.
 *
 * @author  Claudio_Sanches
 * @package WooCommerce_Jadlog/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<p class="wc-jadlog-tracking__description"><?php esc_html_e( 'History for the tracking code:', 'woocommerce-jadlog' ); ?> <strong><?php echo esc_html( $code ); ?></strong></p>

<table class="wc-jadlog-tracking__table woocommerce-table shop_table shop_table_responsive">
	<thead>
		<tr>
			<th><?php esc_html_e( 'Date', 'woocommerce-jadlog' ); ?></th>
			<th><?php esc_html_e( 'Location', 'woocommerce-jadlog' ); ?></th>
			<th><?php esc_html_e( 'Status', 'woocommerce-jadlog' ); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ( $events as $event ) : ?>
		<tr>
			<td><?php echo esc_html( $event->data . ' ' . $event->hora ); ?></td>
			<td>
				<?php echo esc_html( $event->local . ' - ' . $event->cidade . '/' . $event->uf ); ?>

				<?php if ( isset( $event->destino ) ) : ?>
					<br />
					<?php
						/* translators: %s: address */
						echo esc_html( sprintf( __( 'In transit to %s', 'woocommerce-jadlog' ), $event->destino->local . ' - ' . $event->destino->cidade . '/' . $event->destino->uf ) );
					?>
				<?php endif; ?>
			</td>
			<td>
				<?php echo esc_html( $event->descricao ); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3">
				<form method="POST" target="_blank" rel="nofollow noopener noreferrer" action="https://www.jadlog.com.br/sitejadlog/tracking.jad" class="wc-jadlog-tracking__form">
					<input type="hidden" name="Objetos" value="<?php echo esc_attr( $code ); ?>">
					<input class="wc-jadlog-tracking__button button" type="submit" value="<?php esc_attr_e( 'Query on Jadlog', 'woocommerce-jadlog' ); ?>">
				</form>
			</td>
		</tr>
	</tfoot>
</table>
