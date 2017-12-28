<?php
/**
 * Plugin Name:          WooCommerce Jadlog
 * Plugin URI:           https://github.com/FranCompras/woocommerce-correios
 * Description:          Adds Jadlog shipping methods to your WooCommerce store.
 * Author:               Sander Mendes
 * Author URI:           https://francompras.com.br
 * Version:              1.0.0
 * License:              GPLv2 or later
 * Text Domain:          woocommerce-jadlog
 * Domain Path:          /languages
 * WC requires at least: 3.0.0
 * WC tested up to:      3.2.0
 *
 * WooCommerce Jadlog is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * WooCommerce Jadlog is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WooCommerce Jadlog. If not, see
 * <https://www.gnu.org/licenses/gpl-2.0.txt>.
 *
 * @package WooCommerce_Jadlog
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'WC_JADLOG_VERSION', '1.0.0' );
define( 'WC_JADLOG_PLUGIN_FILE', __FILE__ );

if ( ! class_exists( 'WC_Jadlog' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-wc-jadlog.php';

	add_action( 'plugins_loaded', array( 'WC_Jadlog', 'init' ) );
}
