<?php
/**
 * User: robertcierczek
 */

defined( 'ABSPATH' ) || exit;

final class Persondoc_WOOC {
	/**
	 * The single instance of the class
	 *
	 * @var Persondoc_WOOC
	 */
    protected static $instance = null;

	/**
	 * Main instance
	 *
	 * @return Persondoc_WOOC
	 */
	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		$this->init_hooks();
		$this->includes();
	}

	/**
	 * Init plugin actions
	 */
	private function init_hooks() {
		add_action( 'admin_menu', array( $this, 'persondoc_menu' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );

		//Woocomerce login page
		add_action( 'woocommerce_login_form', array( $this, 'persondoc_script' ) );
		add_action( 'woocommerce_register_form', array( $this, 'action_woocommerce_register_form' ) );

	}

	/**
	 * Include required core files
	 */
	public function includes() {
		include_once 'reg-persondoc.php';
	}

	/**
	 * Add menu page
	 */
	public function persondoc_menu() {
		add_menu_page( 'PersonDoc', 'PersonDoc', 'administrator', 'persondoc', array( $this, 'persondoc_options' ) );
	}

	/**
	 * Add menu page settings
	 */
	public function persondoc_options() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		// Set class property
		$this->options = get_option( 'persondoc_option' );
		?>
        <div class="wrap">
            <form method="post" action="options.php">
				<?php
				// This prints out all hidden setting fields
				settings_fields( 'persondoc_group' );
				do_settings_sections( 'persondoc-setting' );
				submit_button();
				?>
            </form>
        </div>
		<?php
	}

	/**
	 * Register and add settings
	 */
	public function page_init() {
		register_setting(
			'persondoc_group', // Option group
			'persondoc_option', // Option name
			array( $this, 'sanitize' ) // Sanitize
		);

		add_settings_section(
			'setting_section_id', // ID
			'PersonDoc Settings', // Title
			array( $this, 'print_section_info' ), // Callback
			'persondoc-setting' // Page
		);


		add_settings_field(
			'api_key',
			'Api Key',
			array( $this, 'api_key_callback' ),
			'persondoc-setting',
			'setting_section_id'
		);
	}

	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 */
	public function sanitize( $input ) {
		$new_input = array();

		if ( isset( $input['api_key'] ) ) {
			$new_input['api_key'] = sanitize_text_field( $input['api_key'] );
		}

		return $new_input;
	}

	/**
	 * Print the Section text
	 */
	public function print_section_info() {
		print '';
	}


	/**
	 * Get the settings option array and print one of its values
	 */
	public function api_key_callback() {
		printf(
			'<input type="text" id="api_key" name="persondoc_option[api_key]" value="%s" />',
			isset( $this->options['api_key'] ) ? esc_attr( $this->options['api_key'] ) : ''
		);
	}


	/**
	 * Add PersonDoc script
	 **/
	public function persondoc_script() {
		wp_enqueue_style( 'persondoc_css', plugins_url() . '/persondoc/asset/css/persondoc.css' );

		wp_enqueue_script( 'persondoc_js', plugins_url() . '/persondoc/asset/js/persondoc.js', null, null, true );

		$dataJs = array(
			'appID' => get_option( "persondoc_option" )["api_key"]
		);

		wp_localize_script( 'persondoc_js', 'php_vars', $dataJs );

		echo '<input onclick="PD.open()" type="button" value="PERSONDOC" class="prsd_button" id="prsdLogin">';

	}


	function action_woocommerce_register_form() {
		echo '<input onclick="PD.open()" type="button" value="PERSONDOC" class="prsd_button" id="prsdRegister">';
	}


}

/**
 * Main instance of plugin
 *
 * @return Persondoc_WCVS
 */
function Persondoc_WCVS() {
	return Persondoc_WOOC::instance();
}

/**
 * Display notice in case of WooCommerce plugin is not activated
 */
function Persondoc_wc_notice() {
	?>

    <div class="error">
        <p><?php esc_html_e( 'Persondoc is enabled but not effective. It requires WooCommerce in order to work.', 'wcvs' ); ?></p>
    </div>

	<?php
}

/**
 * Construct plugin when plugins loaded in order to make sure WooCommerce API is fully loaded
 * Check if WooCommerce is not activated then show an admin notice
 * or create the main instance of plugin
 */
function Persondoc_constructor() {
	if ( ! function_exists( 'WC' ) ) {
		add_action( 'admin_notices', 'Persondoc_wc_notice' );
	} else {
		Persondoc_WCVS();
	}
}

add_action( 'plugins_loaded', 'Persondoc_constructor' );

