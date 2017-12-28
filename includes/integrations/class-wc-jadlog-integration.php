<?php
/**
 * Jadlog integration.
 *
 * @package WooCommerce_Jadlog/Classes/Integration
 * @since   3.0.0
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Jadlog integration class.
 */
class WC_Jadlog_Integration extends WC_Integration {

	/**
	 * Initialize integration actions.
	 */
	public function __construct() {
		$this->id           = 'jadlog-integration';
		$this->method_title = __( 'Jadlog', 'woocommerce-jadlog' );

		// Load the form fields.
		$this->init_form_fields();

		// Load the settings.
		$this->init_settings();

		// Define user set variables.
		$this->tracking_enable         = $this->get_option( 'tracking_enable' );
		$this->tracking_debug          = $this->get_option( 'tracking_debug' );
		$this->autofill_enable         = $this->get_option( 'autofill_enable' );
		$this->autofill_validity       = $this->get_option( 'autofill_validity' );
		$this->autofill_force          = $this->get_option( 'autofill_force' );
		$this->autofill_empty_database = $this->get_option( 'autofill_empty_database' );
		$this->autofill_debug          = $this->get_option( 'autofill_debug' );

		// Actions.
		add_action( 'woocommerce_update_options_integration_' . $this->id, array( $this, 'process_admin_options' ) );

		// Tracking history actions.
		add_filter( 'woocommerce_jadlog_enable_tracking_history', array( $this, 'setup_tracking_history' ), 10 );
		add_filter( 'woocommerce_jadlog_enable_tracking_debug', array( $this, 'setup_tracking_debug' ), 10 );

		// Autofill address actions.
		add_filter( 'woocommerce_jadlog_enable_autofill_addresses', array( $this, 'setup_autofill_addresses' ), 10 );
		add_filter( 'woocommerce_jadlog_enable_autofill_addresses_debug', array( $this, 'setup_autofill_addresses_debug' ), 10 );
		add_filter( 'woocommerce_jadlog_autofill_addresses_validity_time', array( $this, 'setup_autofill_addresses_validity_time' ), 10 );
		add_filter( 'woocommerce_jadlog_autofill_addresses_force_autofill', array( $this, 'setup_autofill_addresses_force_autofill' ), 10 );
		add_action( 'wp_ajax_jadlog_autofill_addresses_empty_database', array( $this, 'ajax_empty_database' ) );
	}

	/**
	 * Get tracking log url.
	 *
	 * @return string
	 */
	protected function get_tracking_log_link() {
		return ' <a href="' . esc_url( admin_url( 'admin.php?page=wc-status&tab=logs&log_file=jadlog-tracking-history-' . sanitize_file_name( wp_hash( 'jadlog-tracking-history' ) ) . '.log' ) ) . '">' . __( 'View logs.', 'woocommerce-jadlog' ) . '</a>';
	}

	/**
	 * Initialize integration settings fields.
	 */
	public function init_form_fields() {
		$this->form_fields = array(
			'tracking'                => array(
				'title'       => __( 'Tracking History Table', 'woocommerce-jadlog' ),
				'type'        => 'title',
				'description' => __( 'Displays a table with informations about the shipping in My Account > View Order page.', 'woocommerce-jadlog' ),
			),
			'tracking_enable'         => array(
				'title'   => __( 'Enable/Disable', 'woocommerce-jadlog' ),
				'type'    => 'checkbox',
				'label'   => __( 'Enable Tracking History Table', 'woocommerce-jadlog' ),
				'default' => 'no',
			),
			'tracking_debug'          => array(
				'title'       => __( 'Debug Log', 'woocommerce-jadlog' ),
				'type'        => 'checkbox',
				'label'       => __( 'Enable logging for Tracking History', 'woocommerce-jadlog' ),
				'default'     => 'no',
				/* translators: %s: log link */
				'description' => sprintf( __( 'Log %s events, such as WebServices requests.', 'woocommerce-jadlog' ), __( 'Tracking History Table', 'woocommerce-jadlog' ) ) . $this->get_tracking_log_link(),
			),
			'autofill_addresses'      => array(
				'title'       => __( 'Autofill Addresses', 'woocommerce-jadlog' ),
				'type'        => 'title',
				'description' => __( 'Displays a table with informations about the shipping in My Account > View Order page.', 'woocommerce-jadlog' ),
			),
			'autofill_enable'         => array(
				'title'   => __( 'Enable/Disable', 'woocommerce-jadlog' ),
				'type'    => 'checkbox',
				'label'   => __( 'Enable Autofill Addresses', 'woocommerce-jadlog' ),
				'default' => 'no',
			),
			'autofill_validity'       => array(
				'title'       => __( 'Postcodes Validity', 'woocommerce-jadlog' ),
				'type'        => 'select',
				'default'     => 'forever',
				'class'       => 'wc-enhanced-select',
				'description' => __( 'Defines how long a postcode will stay saved in the database before a new query.', 'woocommerce-jadlog' ),
				'options'     => array(
					'1'       => __( '1 month', 'woocommerce-jadlog' ),
					/* translators: %s number of months */
					'2'       => sprintf( __( '%d months', 'woocommerce-jadlog' ), 2 ),
					/* translators: %s number of months */
					'3'       => sprintf( __( '%d months', 'woocommerce-jadlog' ), 3 ),
					/* translators: %s number of months */
					'4'       => sprintf( __( '%d months', 'woocommerce-jadlog' ), 4 ),
					/* translators: %s number of months */
					'5'       => sprintf( __( '%d months', 'woocommerce-jadlog' ), 5 ),
					/* translators: %s number of months */
					'6'       => sprintf( __( '%d months', 'woocommerce-jadlog' ), 6 ),
					/* translators: %s number of months */
					'7'       => sprintf( __( '%d months', 'woocommerce-jadlog' ), 7 ),
					/* translators: %s number of months */
					'8'       => sprintf( __( '%d months', 'woocommerce-jadlog' ), 8 ),
					/* translators: %s number of months */
					'9'       => sprintf( __( '%d months', 'woocommerce-jadlog' ), 9 ),
					/* translators: %s number of months */
					'10'      => sprintf( __( '%d months', 'woocommerce-jadlog' ), 10 ),
					/* translators: %s number of months */
					'11'      => sprintf( __( '%d months', 'woocommerce-jadlog' ), 11 ),
					/* translators: %s number of months */
					'12'      => sprintf( __( '%d months', 'woocommerce-jadlog' ), 12 ),
					'forever' => __( 'Forever', 'woocommerce-jadlog' ),
				),
			),
			'autofill_force'          => array(
				'title'       => __( 'Force Autofill', 'woocommerce-jadlog' ),
				'type'        => 'checkbox',
				'label'       => __( 'Enable Force Autofill', 'woocommerce-jadlog' ),
				'description' => __( 'When enabled will autofill all addresses after the user finish to fill the postcode, even if the addresses are already filled.', 'woocommerce-jadlog' ),
				'default'     => 'no',
			),
			'autofill_empty_database' => array(
				'title'       => __( 'Empty Database', 'woocommerce-jadlog' ),
				'type'        => 'button',
				'label'       => __( 'Empty Database', 'woocommerce-jadlog' ),
				'description' => __( 'Delete all the saved postcodes in the database, use this option if you have issues with outdated postcodes.', 'woocommerce-jadlog' ),
			),
			'autofill_debug'          => array(
				'title'       => __( 'Debug Log', 'woocommerce-jadlog' ),
				'type'        => 'checkbox',
				'label'       => __( 'Enable logging for Autofill Addresses', 'woocommerce-jadlog' ),
				'default'     => 'no',
				/* translators: %s: log link */
				'description' => sprintf( __( 'Log %s events, such as WebServices requests.', 'woocommerce-jadlog' ), __( 'Autofill Addresses', 'woocommerce-jadlog' ) ) . $this->get_tracking_log_link(),
			),
		);
	}

	/**
	 * Jadlog options page.
	 */
	public function admin_options() {
		echo '<h2>' . esc_html( $this->get_method_title() ) . '</h2>';
		echo wp_kses_post( wpautop( $this->get_method_description() ) );

		include WC_Jadlog::get_plugin_path() . 'includes/admin/views/html-admin-help-message.php';

		if ( class_exists( 'SoapClient' ) ) {
			echo '<div><input type="hidden" name="section" value="' . esc_attr( $this->id ) . '" /></div>';
			echo '<table class="form-table">' . $this->generate_settings_html( $this->get_form_fields(), false ) . '</table>'; // WPCS: XSS ok.
		} else {
			$GLOBALS['hide_save_button'] = true; // Hide save button.
			/* translators: %s: SOAP documentation link */
			echo '<div class="notice notice-error inline"><p>' . sprintf( esc_html__( 'It\'s required have installed the %s on your server in order to integrate with the services of the Jadlog!', 'woocommerce-jadlog' ), '<a href="https://secure.php.net/manual/book.soap.php" target="_blank" rel="nofollow noopener noreferrer">' . esc_html__( 'SOAP module', 'woocommerce-jadlog' ) . '</a>' ) . '</p></div>';
		}

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_enqueue_script( $this->id . '-admin', plugins_url( 'assets/js/admin/integration' . $suffix . '.js', WC_Jadlog::get_main_file() ), array( 'jquery', 'jquery-blockui' ), WC_JADLOG_VERSION, true );
		wp_localize_script(
			$this->id . '-admin',
			'WCJadlogIntegrationAdminParams',
			array(
				'i18n_confirm_message' => __( 'Are you sure you want to delete all postcodes from the database?', 'woocommerce-jadlog' ),
				'empty_database_nonce' => wp_create_nonce( 'woocommerce_jadlog_autofill_addresses_nonce' ),
			)
		);
	}

	/**
	 * Generate Button Input HTML.
	 *
	 * @param string $key  Input key.
	 * @param array  $data Input data.
	 * @return string
	 */
	public function generate_button_html( $key, $data ) {
		$field_key = $this->get_field_key( $key );
		$defaults  = array(
			'title'       => '',
			'label'       => '',
			'desc_tip'    => false,
			'description' => '',
		);

		$data = wp_parse_args( $data, $defaults );

		ob_start();
		?>
		<tr valign="top">
			<th scope="row" class="titledesc">
				<label for="<?php echo esc_attr( $field_key ); ?>"><?php echo wp_kses_post( $data['title'] ); ?></label>
				<?php echo $this->get_tooltip_html( $data ); // WPCS: XSS ok. ?>
			</th>
			<td class="forminp">
				<fieldset>
					<legend class="screen-reader-text"><span><?php echo wp_kses_post( $data['title'] ); ?></span></legend>
					<button class="button-secondary" type="button" id="<?php echo esc_attr( $field_key ); ?>"><?php echo wp_kses_post( $data['label'] ); ?></button>
					<?php echo $this->get_description_html( $data ); // WPCS: XSS ok. ?>
				</fieldset>
			</td>
		</tr>
		<?php

		return ob_get_clean();
	}

	/**
	 * Enable tracking history.
	 *
	 * @return bool
	 */
	public function setup_tracking_history() {
		return 'yes' === $this->tracking_enable && class_exists( 'SoapClient' );
	}

	/**
	 * Set up tracking debug.
	 *
	 * @return bool
	 */
	public function setup_tracking_debug() {
		return 'yes' === $this->tracking_debug;
	}

	/**
	 * Enable autofill addresses.
	 *
	 * @return bool
	 */
	public function setup_autofill_addresses() {
		return 'yes' === $this->autofill_enable && class_exists( 'SoapClient' );
	}

	/**
	 * Set up autofill addresses debug.
	 *
	 * @return bool
	 */
	public function setup_autofill_addresses_debug() {
		return 'yes' === $this->autofill_debug;
	}

	/**
	 * Set up autofill addresses validity time.
	 *
	 * @return string
	 */
	public function setup_autofill_addresses_validity_time() {
		return $this->autofill_validity;
	}

	/**
	 * Set up autofill addresses force autofill.
	 *
	 * @return string
	 */
	public function setup_autofill_addresses_force_autofill() {
		return $this->autofill_force;
	}

	/**
	 * Ajax empty database.
	 */
	public function ajax_empty_database() {
		global $wpdb;

		if ( ! isset( $_POST['nonce'] ) ) { // WPCS: input var okay, CSRF ok.
			wp_send_json_error( array( 'message' => __( 'Missing parameters!', 'woocommerce-jadlog' ) ) );
			exit;
		}

		if ( ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['nonce'] ) ), 'woocommerce_jadlog_autofill_addresses_nonce' ) ) { // WPCS: input var okay, CSRF ok.
			wp_send_json_error( array( 'message' => __( 'Invalid nonce!', 'woocommerce-jadlog' ) ) );
			exit;
		}

		$table_name = $wpdb->prefix . WC_Jadlog_Autofill_Addresses::$table;
		$wpdb->query( "DROP TABLE IF EXISTS $table_name;" ); // @codingStandardsIgnoreLine

		WC_Jadlog_Autofill_Addresses::create_database();

		wp_send_json_success( array( 'message' => __( 'Postcode database emptied successfully!', 'woocommerce-jadlog' ) ) );
	}
}
