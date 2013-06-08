<?php // custom functions.php template


//Activate compression
if(extension_loaded("zlib") && (ini_get("output_handler") != "ob_gzhandler"))
add_action('wp', create_function('', '@ob_end_clean();@ini_set("zlib.output_compression", 1);'));

//keep users fronm logging into admin
add_action( 'init', 'really_block_users' );
 
function really_block_users() {
      $isAjax = (defined('DOING_AJAX') && true === DOING_AJAX) ? true : false;

    if(!$isAjax) {
       
        if ( is_admin() && ! current_user_can( 'administrator' ) ) {
            wp_redirect( home_url() );
            exit;
        }
       
    }
}

// smart jquery inclusion
if (!is_admin()) {
	wp_deregister_script('jquery');
	wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"), false, '1.9.1');
	wp_enqueue_script('jquery');
}

// load skeleton
add_action('wp_enqueue_scripts', 'load_css_files');

function load_css_files() {
    wp_register_style( 'skeleton', get_template_directory_uri() . '/css/skeleton.css');
    wp_enqueue_style( 'skeleton' );

    wp_register_style( 'base', get_template_directory_uri() . '/css/base.css');
    wp_enqueue_style( 'base' );

    wp_register_style( 'layout', get_template_directory_uri() . '/css/layout.css');
    wp_enqueue_style( 'layout' );
}


// enable threaded comments
function enable_threaded_comments(){
	if (!is_admin()) {
		if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1))
			wp_enqueue_script('comment-reply');
		}
}
add_action('get_header', 'enable_threaded_comments');


// remove junk from head
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

// custom excerpt length
function custom_excerpt_length($length) {
	return 20;
}
add_filter('excerpt_length', 'custom_excerpt_length');


// custom excerpt ellipses for 2.9+
function custom_excerpt_more($more) {
	return '...';
}
add_filter('excerpt_more', 'custom_excerpt_more');

/* custom excerpt ellipses for 2.8-
function custom_excerpt_more($excerpt) {
	return str_replace('[...]', '...', $excerpt);
}
add_filter('wp_trim_excerpt', 'custom_excerpt_more'); 
*/


// no more jumping for read more link
function no_more_jumping($post) {
	return '<a href="'.get_permalink($post->ID).'" class="read-more">'.'Weiterlesen'.'</a>';
}
add_filter('excerpt_more', 'no_more_jumping');


// add a favicon to your 
function blog_favicon() {
	echo '<link rel="apple-touch-icon" sizes="114x114" href="'.get_bloginfo('wpurl').'/images/apple-touch-icon.png">';
	echo '<link rel="icon" href="'.get_bloginfo('wpurl').'/images/favicon.png">';
	echo '<!--[if IE]><link rel="shortcut icon" href="'.get_bloginfo('wpurl').'/images/favicon.ico"><![endif]-->';
	echo '<!-- or, set /favicon.ico for IE10 win -->';
	echo '<meta name="msapplication-TileColor" content="#A61008">';
	echo '<meta name="msapplication-TileImage" content="'.get_bloginfo('wpurl').'/images/tile-icon.png">';
}
add_action('wp_head', 'blog_favicon');


// add a favicon for your admin
function admin_favicon() {
	echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_bloginfo('stylesheet_directory').'/images/favicon.png" />';
}
add_action('admin_head', 'admin_favicon');


// custom admin login logo
function custom_login_logo() {
	echo '<style type="text/css">
	h1 a { background-image: url('.get_bloginfo('template_directory').'/images/custom-login-logo.png) !important; }
	</style>';
}
add_action('login_head', 'custom_login_logo');


// disable all widget areas
function disable_all_widgets($sidebars_widgets) {
	//if (is_home())
		$sidebars_widgets = array(false);
	return $sidebars_widgets;
}
add_filter('sidebars_widgets', 'disable_all_widgets');

// kill the admin nag
if (!current_user_can('edit_users')) {
	add_action('init', create_function('$a', "remove_action('init', 'wp_version_check');"), 2);
	add_filter('pre_option_update_core', create_function('$a', "return null;"));
}

// remove version info from head and feeds
function complete_version_removal() {
	return '';
}
add_filter('the_generator', 'complete_version_removal');

// delay feed update
function publish_later_on_feed($where) {
	global $wpdb;

	if (is_feed()) {
		// timestamp in WP-format
		$now = gmdate('Y-m-d H:i:s');

		// value for wait; + device
		$wait = '5'; // integer

		// http://dev.mysql.com/doc/refman/5.0/en/date-and-time-functions.html#function_timestampdiff
		$device = 'MINUTE'; // MINUTE, HOUR, DAY, WEEK, MONTH, YEAR

		// add SQL-sytax to default $where
		$where .= " AND TIMESTAMPDIFF($device, $wpdb->posts.post_date_gmt, '$now') > $wait ";
	}
	return $where;
}
add_filter('posts_where', 'publish_later_on_feed');

// count words in posts
function word_count() {
	global $post;
	echo str_word_count($post->post_content);
}

// category id in body and post class
function category_id_class($classes) {
	global $post;
	foreach((get_the_category($post->ID)) as $category)
		$classes [] = 'cat-' . $category->cat_ID . '-id';
		return $classes;
}
add_filter('post_class', 'category_id_class');
add_filter('body_class', 'category_id_class');


// get the first category id
function get_first_category_ID() {
	$category = get_the_category();
	return $category[0]->cat_ID;
}

// Register custom Navigation menu
if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(
		  'main_menu' => __( 'Main Menu', 'cake' ),
		  'secondary_menu' => __( 'Secondary Menu', 'cake' ),
		  'mobile_menu' => __( 'Mobile Menu', 'cake' ),
		)
	);
}
    if (function_exists('register_sidebar')) {
    	register_sidebar(array(
    		'name' => 'Sidebar Widgets',
    		'id'   => 'sidebar-widgets',
    		'description'   => 'These are widgets for the sidebar.',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</div>',
    		'before_title'  => '<h4>',
    		'after_title'   => '</h4>'
    	));
    }

// add google analytics to footer
function add_google_analytics() {
	echo '<script async src="http://www.google-analytics.com/ga.js" type="text/javascript"></script>';
	echo '<script defer type="text/javascript">';
	echo 'var pageTracker = _gat._getTracker("UA-XXXXXXXX-XX");';
	echo 'pageTracker._trackPageview();';
	echo '</script>';
}
add_action('wp_footer', 'add_google_analytics');


// Set content width value based on the theme's design
if ( ! isset( $content_width ) )
	$content_width = 960;

if ( ! function_exists('skeleton_template_features') ) {

// Register Theme Features
function skeleton_template_features()  {
	global $wp_version;

	// add text domain for easy translations
	load_theme_textdomain('skeleton_template', get_template_directory() . '/languages');

	// Add theme support for Automatic Feed Links
	if ( version_compare( $wp_version, '3.0', '>=' ) ) :
		add_theme_support( 'automatic-feed-links' );
	else :
		automatic_feed_links();
	endif;

	// Add theme support for Post Formats
	$formats = array( 'status', 'quote', 'gallery', 'image', 'video', 'audio', 'link', 'aside', 'chat', );
	add_theme_support( 'post-formats', $formats );	

	// Add theme support for Featured Images
	add_theme_support( 'post-thumbnails' );	

	 // Set custom thumbnail dimensions
	set_post_thumbnail_size( 960, 480, true );
	// regular size
	add_image_size( 'regular', 480, '');
	// medium size
	add_image_size( 'medium', 768, '');
	// large thumbnails
	add_image_size( 'large', 960, '' );

// show custom image sizes on when inserting media
function cake_show_image_sizes($sizes) {
    $sizes['regular'] = __( 'Our Regular Size', 'cake' );
    $sizes['medium'] = __( 'Our Medium Size', 'cake' );
    $sizes['large'] = __( 'Our Large Size', 'cake' );
    return $sizes;
}
add_filter('image_size_names_choose', 'cake_show_image_sizes');

//remove inline width and height added to images
	add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
	add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );
	// Removes attached image sizes as well
	add_filter( 'the_content', 'remove_thumbnail_dimensions', 10 );
	function remove_thumbnail_dimensions( $html ) {
    		$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    		return $html;
	}

	function custom_upload_mimes ( $existing_mimes=array() ) {
	// add the file extension to the array
	$existing_mimes['svg'] = 'mime/type';
    // call the modified list of extensions
	return $existing_mimes;
}
add_filter('upload_mimes', 'custom_upload_mimes');

	// Add theme support for Custom Background
	$background_args = array(
		'default-color'          => '#fff',
		'default-image'          => '',
		'wp-head-callback'       => '_custom_background_cb',
		'admin-head-callback'    => '',
		'admin-preview-callback' => '',
	);
	if ( version_compare( $wp_version, '3.4', '>=' ) ) :
		add_theme_support( 'custom-background', $background_args );
	else :
		add_custom_background();
	endif;

	// Add theme support for Custom Header
	$header_args = array(
		'default-image'          => '',
		'width'                  => 1920,
		'height'                 => 256,
		'flex-width'             => true,
		'flex-height'            => true,
		'random-default'         => false,
		'header-text'            => false,
		'default-text-color'     => '#fff',
		'uploads'                => true,

	);
	if ( version_compare( $wp_version, '3.4', '>=' ) ) :
		add_theme_support( 'custom-header', $header_args );
	else :
		add_custom_image_header();
	endif;
}

add_theme_support( 'infinite-scroll', array(
    'type'           => 'scroll',
    'footer_widgets' => false,
    'container'      => 'index',
    'wrapper'        => true,
    'render'         => false,
    'posts_per_page' => false
) );

// Hook into the 'after_setup_theme' action
add_action( 'after_setup_theme', 'skeleton_template_features' );

}

// shortcode for showing code
function short_code( $atts , $content = null ) {
return '<pre class="code">' . do_shortcode( $content ) . '</pre>';
}
add_shortcode( 'code', 'short_code' );

// shortcode for two columns
function two_columns( $atts , $content = null ) {
return '<div class="eight columns">' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'two-columns', 'two_columns' );

// shortcode for three columns
function three_columns( $atts , $content = null ) {
return '<div class="one-third column">' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'three-columns', 'three_columns' );

// shortcode for four columns
function four_columns( $atts , $content = null ) {
return '<div class="four columns">' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'four-columns', 'four_columns' );


add_action('init', 'project_custom_init');    
      
    /*-- Custom Post Init Begin --*/  
    function project_custom_init()  
    {  
      $labels = array(  
        'name' => _x('Projects', 'post type general name'),  
        'singular_name' => _x('Project', 'post type singular name'),  
        'add_new' => _x('Add New', 'project'),  
        'add_new_item' => __('Add New Project'),  
        'edit_item' => __('Edit Project'),  
        'new_item' => __('New Project'),  
        'view_item' => __('View Project'),  
        'search_items' => __('Search Projects'),  
        'not_found' =>  __('No projects found'),  
        'not_found_in_trash' => __('No projects found in Trash'),  
        'parent_item_colon' => '',  
        'menu_name' => 'Project'  
      
      );  
        
     $args = array(  
        'labels' => $labels,  
        'public' => true,  
        'publicly_queryable' => true,  
        'show_ui' => true,  
        'show_in_menu' => true,  
        'query_var' => true,  
        'rewrite' => true,  
        'capability_type' => 'post',  
        'has_archive' => true,  
        'hierarchical' => false,  
        'menu_position' => null,  
        'supports' => array('title','editor','author','thumbnail','excerpt','comments')  
      );  
      // The following is the main step where we register the post.  
      register_post_type('project',$args);  
        
      // Initialize New Taxonomy Labels  
      $labels = array(  
        'name' => _x( 'Tags', 'taxonomy general name' ),  
        'singular_name' => _x( 'Tag', 'taxonomy singular name' ),  
        'search_items' =>  __( 'Search Types' ),  
        'all_items' => __( 'All Tags' ),  
        'parent_item' => __( 'Parent Tag' ),  
        'parent_item_colon' => __( 'Parent Tag:' ),  
        'edit_item' => __( 'Edit Tags' ),  
        'update_item' => __( 'Update Tag' ),  
        'add_new_item' => __( 'Add New Tag' ),  
        'new_item_name' => __( 'New Tag Name' ),  
      );  
        // Custom taxonomy for Project Tags  
        register_taxonomy('tagportfolio',array('project'), array(  
        'hierarchical' => true,  
        'labels' => $labels,  
        'show_ui' => true,  
        'query_var' => true,  
        'rewrite' => array( 'slug' => 'tag-portfolio' ),  
      ));  
        
    }  
    /*-- Custom Post Init Ends --*/  


    /*--- Demo URL meta box ---*/
	
	add_action('admin_init','portfolio_meta_init');
	
	function portfolio_meta_init()
	{
		// add a meta box for wordpress 'project' type
		add_meta_box('portfolio_meta', 'Project Infos', 'portfolio_meta_setup', 'project', 'side', 'low');
	 
		// add a callback function to save any data a user enters in
		add_action('save_post','portfolio_meta_save');
	}
	
	function portfolio_meta_setup()
	{
		global $post;
	 	 
		?>
			<div class="portfolio_meta_control">
				<label>URL</label>
				<p>
					<input type="text" name="_url" value="<?php echo get_post_meta($post->ID,'_url',TRUE); ?>" style="width: 100%;" />
				</p>
			</div>
		<?php

		// create for validation
		echo '<input type="hidden" name="meta_noncename" value="' . wp_create_nonce(__FILE__) . '" />';
	}
	
	function portfolio_meta_save($post_id) 
	{
		// check nonce
		if (!isset($_POST['meta_noncename']) || !wp_verify_nonce($_POST['meta_noncename'], __FILE__)) {
		return $post_id;
		}

		// check capabilities
		if ('post' == $_POST['post_type']) {
		if (!current_user_can('edit_post', $post_id)) {
		return $post_id;
		}
		} elseif (!current_user_can('edit_page', $post_id)) {
		return $post_id;
		}

		// exit on autosave
		if (defined('DOING_AUTOSAVE') == DOING_AUTOSAVE) {
		return $post_id;
		}

		if(isset($_POST['_url'])) 
		{
			update_post_meta($post_id, '_url', $_POST['_url']);
		} else 
		{
			delete_post_meta($post_id, '_url');
		}
	}
	
	/*--- #end  Demo URL meta box ---*/
	
	function enqueue_filterable() 
	{
		wp_register_script( 'filterable', get_template_directory_uri() . '/js/filterable.js', array( 'jquery' ) );
		wp_enqueue_script( 'filterable' );
	}
	add_action('wp_enqueue_scripts', 'enqueue_filterable');


?>