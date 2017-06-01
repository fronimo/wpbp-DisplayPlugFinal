<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://fsylumin.net
 * @since      1.0.0
 *
 * @package    Outdated_Notice
 * @subpackage Outdated_Notice/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Outdated_Notice
 * @subpackage Outdated_Notice/admin
 * @author     Alfre <alfredo@inka-labs.com>
 */
class Outdated_Notice_Admin {

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

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/outdated-notice-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/outdated-notice-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add an options page under the Settings submenu
	 *
	 * @since  1.0.0
	 */

	public function add_menu_page() {

		$this->plugin_screen_hook_suffix = add_menu_page(
			__( 'Outdated Notice Settings', 'outdated-notice' ),
			__( 'Outdated Notice', 'outdated-notice' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' )
		);

	}

	/**
	 * Render the options page for plugin
	 *
	 * @since  1.0.0
	 */
	public function display_options_page() {
		include_once 'partials/outdated-notice-admin-display.php';
		global $wpdb;
		echo '<p>'. __('Please change the settings accordingly.', 'outdated-notice' ) . '</p>';
		//$dbname = "easyfolio_dev";
		//global $wpdb;
		$dir = admin_url('admin.php?page='.$this->plugin_name);
 		$store_image_path = "";
 		$upload_dir = wp_upload_dir();
 		$upload_path = $upload_dir['url']."/";
 		/*
  		$site = site_url();
  		$ocurrence = strpos($upload_dir['path'],'wp-content');
  		$upload_path = $site."/".substr($upload_dir['path'], $ocurrence)."/";
		*/

		if(isset($_GET['id'])){
   			if($_GET['flag'] == "edit"){
      
        //select from data base and load the data to edit

        	$row = $wpdb->get_row('SELECT * FROM efwp_images WHERE id = '.$_GET['id'].'');
        	$id = $row->id;
        	$image_path = $row->image_path;
        	$comment = $row->comment;
        	//doble contenido store_image_path
        	$store_image_path = $image_path;
    		}

		    if($_GET['flag'] == "delete"){
		        //delete from data base
		        $wpdb->delete('efwp_images', array(
		                                    'id'=>$_GET['id']
		                                    ));
		    }
	  	}
			//---------------------------------------------------------------------------------------------------------------------
	  	if(isset($_POST['submit']) && ($_POST['comment']!="")){

         
		    if(($_FILES['image']['name'] ==="") && ($image_path == "")){
		    	echo "Choose an image";

		    }

		    if(($_FILES['image']['name'] ==="") && ($image_path != "")){
		      
		        $store_image_sub_path = substr(strrchr($store_image_path,"/"),1);
		        $_FILES['image']['name']= $store_image_sub_path;
		    }
    
    
    		$comment = $_POST['comment'];


	        $errors= array();
	        $file_name = $_FILES['image']['name'];
	        $file_size = $_FILES['image']['size'];
	        $file_tmp = $_FILES['image']['tmp_name'];
	        $file_type = $_FILES['image']['type'];
	        $tmp_end = explode('.',$_FILES['image']['name']);
	        $file_ext = strtolower(end($tmp_end));
	      
	        $extensions= array("jpeg","jpg","png");
	      
	        if ( ! function_exists( 'wp_handle_upload' ) ) {
	          require_once( ABSPATH . 'wp-admin/includes/file.php' );
	        }
      
      
	        if (in_array($file_ext, $extensions)) {

		        $uploadedfile = $_FILES['image'];
		        $upload_overrides = array( 'test_form' => false );
		        $movefile = wp_handle_upload($uploadedfile, $upload_overrides);
	        
		        if (isset($_POST['id']) && !empty($_POST['id'])) {
		        //update

		          $wpdb->update('efwp_images', array(
		                                  'image_path' => $upload_path.$_FILES['image']['name'],
		                                  'comment' => $_POST["comment"]
		                                ),
		                              array('id'=> $_POST['id']));
		          $image_path = $upload_path.$_FILES['image']['name'];
		          echo "DATA UPDATED";

		        } else {
		        //create
		      
		            $wpdb->insert('efwp_images', array(
		                                'image_path' => $upload_path.$_FILES['image']['name'],
		                                'comment' => $_POST["comment"]
		                              ));
		            $image_path = $upload_path.$_FILES['image']['name'];
		            echo "<h2>Values Inserted!</h2>";  
		        }

	        	echo "extension allowed! ";
	        }

	    }
	    else{
	        //echo "<h3>extension not allowed, please choose a JPEG, JPG or PNG file.</h3>";
	        echo "<h3>Please Complete all fields</h3>";
	    }

	    $results = $wpdb->get_results("SELECT * FROM efwp_images");

	    ?>
		<table>
		    <tr><th>ID</th><th>Path</th><th>Comment</th><tr>
		<?php
		$images="";

  		$my_results = $results;
  		foreach ($my_results as $result) {
	    	echo '<tr>
	            	<td>' .$result->id. '</td>
	            	<td>' .$result->image_path. '</td>
	            	<td>' .$result->comment. '</td>
	            	<td><a href="'.$dir.'&id='.$result->id.'&comment='.$result->comment.'&flag=edit">edit</a>
	                         &nbsp;|&nbsp;
	                <a href="'.$dir.'&id='.$result->id.'&comment='.$result->comment.'&flag=delete" >delete</a>
	          	 </tr>';
	  		$images .=  '<li> <img src="' . $result->image_path . '"> </li>';
	  	}

	  	?>



		<div class="fillForm">
		  <form enctype="multipart/form-data" method="post">
		        Path <?php echo isset($image_path) ? $image_path : 'No se guardo nada'; ?> </br>
		        <img src="<?php echo isset($image_path) ? $image_path : null; ?>" /> </br>
		        Comment:<br>
		        <input type="text" name="comment" placeholder="Comentario" value="<?php echo isset($comment) ? $comment : null; ?>" /> <br>
		        <br>
		        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : null; ?>"/>
		        image: <br>
		        <input type="file" name="image" />
		        <input type="submit" name="submit" value="Submit" />
		        </form>
		</div>  

		<?php
	}  

		//en estrucutra--

	 /* echo'
	    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	    <script src="/wp-content/plugins/admin-panel/js/jquery.bxslider.js"></script>
	    <link href="/wp-content/plugins/admin-panel/lib/jquery.bxslider.css" rel="stylesheet" />
	    <script>
	    $(document).ready(function(){
	        $(".bxslider").bxSlider();
	    });
	    </script>
	    
	    <ul class="bxslider">
	      '.$images.'
	    </ul>';
	 		
		*/

}