<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.linkedin.com/in/s4hilk/
 * @since      1.0.0
 *
 * @package    Nr_Tracking
 * @subpackage Nr_Tracking/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Nr_Tracking
 * @subpackage Nr_Tracking/public
 * @author     Sahil Khanna <websupport@nativerank.com>
 */
class Nr_Tracking_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->wp_nr_options = get_option($this->plugin_name);
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/nr-tracking-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/nr-tracking-public.js', array( 'jquery' ), $this->version, false );

	}


/**
*
* public/class-wp-cbf-public.php
*
**/

 

    /**
     * Cleanup functions depending on each checkbox returned value in admin
     *
     * @since    1.0.0
     */


    
    public function nr_tr_add_gtm_container() {
   				
   				if($this->wp_nr_options['gtm_container'])
   				{
   				$tag = $this->wp_nr_options['gtm_container'];
   				echo "<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','$tag');</script>
<!-- End Google Tag Manager -->\n";
   			}
   		}

   		public function nr_tr_add_gtm_noscript() {
   				
   				if($this->wp_nr_options['gtm_container'])
   				{
   				$tag = $this->wp_nr_options['gtm_container'];
   				echo '<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id='.$tag.'"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->';
   			}
   		}

	public function nr_tr_add_bing_code() {
		if($this->wp_nr_options['bing_code'])
		{
		$tag = $this->wp_nr_options['bing_code'];
		echo "<meta name=\"msvalidate.01\" content=\"$tag\">\n";
		}
	}


	public function nr_tr_add_local_schema() {
		if($this->wp_nr_options['nr_tr_local_schema'])
		{
		$schema = $this->wp_nr_options['nr_tr_local_schema'];
		echo "<script type='application/ld+json'>$schema</script>\n";
		}
	}

    public function nr_tr_add_development_mode() {
        if($this->wp_nr_options['nr_tr_development_mode'])
        {
            echo "<!--DEVELOPMENT MODE ENABLED-->\n<script>console.log('%c NATIVERANK', 'background: #222; color: #f44336;font-weight:800;letter-spacing:2px;', 'Development mode is enabled');</script>\n

<link rel=\"stylesheet/less\" type=\"text/css\" href=\"".get_site_url()."/wp-content/themes/yootheme_child/less/src/custom.less\" />\n
    <script>less = { logLevel: 2,\n
            env: 'development',\n
            dumpLineNumbers: \"comments\"\n
        };</script>
    <script src=\"//cdnjs.cloudflare.com/ajax/libs/less.js/3.5.0/less.min.js\" ></script>\n
    <script>less.watch();</script>\n
";
        }
    }


}
