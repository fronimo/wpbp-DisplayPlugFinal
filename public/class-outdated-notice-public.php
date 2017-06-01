<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://fsylumin.net
 * @since      1.0.0
 *
 * @package    Outdated_Notice
 * @subpackage Outdated_Notice/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Outdated_Notice
 * @subpackage Outdated_Notice/public
 * @author     Alfre <alfredo@inka-labs.com>
 */
class Outdated_Notice_Public {

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
		 * defined in Outdated_Notice_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Outdated_Notice_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/jquery.bxslider-public.css', array(), $this->version, 'all' );

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
		 * defined in Outdated_Notice_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Outdated_Notice_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/outdated-notice-public.js', array( 'jquery' ), $this->version, true );
		//wp_enqueue_script( 'slider', plugin_dir_url( __FILE__ ) . 'js/jquery.bxslider.js', array( 'jquery' ), $this->version, true );

	}

	public function bold_text() {
  		$content = "HOLAAAAAAA";

  		return '<br><strong>' . $content . '</strong>';

	}

	public function contenido($post_content){
		global $wpdb;
		$results = $wpdb->get_results("SELECT * FROM efwp_images");
		print_r($results);
		$images="";

  		$my_results = $results;
  		foreach ($my_results as $result) {
	        $result->image_path;
	        $images .=  '<li> <img src="' . $result->image_path . '"> </li>';
	  	}

	  	echo '<script>
	  	    $(document).ready(function(){
	  	        $(".bxslider").bxSlider();
	  	    });
	  	    </script>
	  	    
	  	    <ul class="bxslider">
	  	      '.$images.'
	  	    </ul>';

		$tmp = $images;
		$post_content.=$tmp;
		return $post_content;
	}


}
