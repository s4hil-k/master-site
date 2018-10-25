<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.linkedin.com/in/s4hilk/
 * @since      1.0.0
 *
 * @package    Nr_Tracking
 * @subpackage Nr_Tracking/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Nr_Tracking
 * @subpackage Nr_Tracking/admin
 * @author     Sahil Khanna <websupport@nativerank.com>
 */
class Nr_Tracking_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        $this->wp_nr_options = get_option($this->plugin_name);

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles($hook) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Nr_Tracking_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Nr_Tracking_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		global $page_hook_suffix;

		if( $hook != $page_hook_suffix )
		{
        return;
    	}
		wp_enqueue_style( $this->plugin_name, 'https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Nr_Tracking_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Nr_Tracking_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		global $page_hook_suffix;

		if( $hook != $page_hook_suffix )
		{
        return;
    	}

		wp_enqueue_script( $this->plugin_name, 'https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js', array( 'jquery' ), $this->version, false );

	}

	public function add_plugin_admin_menu() {

    /*
     * Add a settings page for this plugin to the Settings menu.
     *
     * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
     *
     *        Administration Menus: http://codex.wordpress.org/Administration_Menus
     *
     */
    global $page_hook_suffix;

    $page_hook_suffix = add_menu_page( 'Native Rank Essentials', '<b style="color:#f44336">NATIVE</b><b style="color:#1D8BF1">RANK</b>', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page'),
         get_site_url(). '/wp-content/plugins/nr-tracking/admin/partials/logo.png'
    );
}

 /**
 * Add settings action link to the plugins page.
 *
 * @since    1.0.0
 */

public function add_action_links( $links ) {
    /*
    *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
    */
   $settings_link = array(
    '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
   );
   return array_merge(  $settings_link, $links );

}

/**
 * Render the settings page for this plugin.
 *
 * @since    1.0.0
 */

public function display_plugin_setup_page() {
    include_once( 'partials/nr-tracking-admin-display.php' );
}

 public function options_update() {
    register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
 }

public function validate($input) {
    
    $valid = array();

    //GTM
    $valid['gtm_container'] = sanitize_text_field($input['gtm_container']);

    //Bing
    $valid['bing_code'] = sanitize_text_field($input['bing_code']);

    //schema
    $valid['nr_tr_local_schema'] = sanitize_text_field($input['nr_tr_local_schema']);

    $valid['nr_tr_development_mode'] = $input['nr_tr_development_mode'];

    return $valid;
 }

    public function nr_tr_toolbar_link( $wp_admin_bar )
    {
        if ($this->wp_nr_options['nr_tr_development_mode']) {
            $args = array(
                'id' => $this->plugin_name,
                'title' => '<div style="    display: flex;
    align-items: center;
    position: absolute;
    top: 0;
    left: calc(100vw - 576px);
    width: 152px;
    z-index: 99;
    transform: translateX(-100%);
    border-right: 1px solid #fff;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 38 38" style="enable-background:new 0 0 38 38;" xml:space="preserve" height="15" width="15">
<style type="text/css">
	.st0{fill:none;stroke:#FF2C2C;stroke-width:2;stroke-opacity:0.5;}
	.st1{fill:none;stroke:#FF2C2C;stroke-width:2;}
	.st2{fill:#FFCD05;}
	.st3{fill:#E11E26;}
</style>
<g>
	<g transform="translate(1 1)">
		<circle class="st0" cx="18" cy="18" r="18"/>
		




	</g>
</g>
<path class="st2" d="M19,36C9.7,36,2,28.4,2,19S9.7,2,19,2s17,7.6,17,17S28.4,36,19,36L19,36z"/>
<path class="st3" d="M25.7,10.3v8.9c0,0.3,0,0.5,0.1,1.1l-0.6-0.8c-0.4-0.4-0.8-0.8-1.2-1.2l0,0c-0.5-0.5-1.2-1.2-1.8-1.8  c-1.1-1-2-1.8-3.2-2.6c-1.1-0.8-2.2-1.5-3.4-2.1c-1.1-0.6-2.4-1.1-3.5-1.5H9v15.2h3.6V15.3c0-0.2,0-0.4-0.1-1.1l0.5,0.2l0.4,0.2  c2.1,0.9,4,2,5.8,3.6l0,0l0.3,0.2c2.3,2.1,4.3,4.5,6.1,7h3.9V10.3C29.5,10.3,25.7,10.3,25.7,10.3z"/>
</svg> <span style="margin-left:5px;color:#43a047">Development Mode</span></div>',
                'meta' => array('class' => 'nr_tr_development_mode_admin_tb')
            );
            $wp_admin_bar->add_node($args);
        }
    }


}


