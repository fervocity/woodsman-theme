<?php
	/**
	 * Starkers functions and definitions
	 *
	 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
	 *
 	 * @package 	WordPress
 	 * @subpackage 	Starkers
 	 * @since 		Starkers 4.0
	 */

	/* ========================================================================================================================
	
	Required external files
	
	======================================================================================================================== */

	require_once( 'external/starkers-utilities.php' );

	/* ========================================================================================================================
	
	Theme specific settings

	Uncomment register_nav_menus to enable a single menu with the title of "Primary Navigation" in your theme
	
	======================================================================================================================== */

	add_theme_support('post-thumbnails');
	
	// register_nav_menus(array('primary' => 'Primary Navigation'));

	/* ========================================================================================================================
	
	Actions and Filters
	
	======================================================================================================================== */

	// add_action( 'wp_enqueue_scripts', 'starkers_script_enqueuer' );

	add_filter( 'body_class', array( 'Starkers_Utilities', 'add_slug_to_body_class' ) );

	/* ========================================================================================================================
	
	Custom Post Types - include custom post types and taxonimies here e.g.

	e.g. require_once( 'custom-post-types/your-custom-post-type.php' );
	
	======================================================================================================================== */


	function shared_region_post() {
		$labels = array(
			'name'					=> _x( 'Shared Region', 'post type general name' ),
			'singular name'			=> _x( 'Shared', 'post type singular name' ),
			'add_new'				=> _x( 'Add New', 'shared_region' ),
			'add_new_item' 			=> __( 'Add New Shared Region' ),
			'edit_item'				=> __( 'Edit Shared Region' ),
			'new_item'				=> __( 'New Shared Region' ),
			'all_items'				=> __( 'All Shared Regions' ),
			'view_item'				=> __( 'View Shared Regions' ),
			'search_items'			=> __( 'Search Shared Regions' ),
			'not_found'				=> __( 'No Shared Regions found' ),
			'not_found_in_trash'	=> __( 'No Shared Regions found in the Trash' ),
			'parent_item_colon'		=> '',
			'menu_name'				=> 'Shared Regions'
		);
		$args = array(
			'labels'			=> $labels,
			'description'		=> 'Holds our shared regions data',
			'public'			=> true,
			'menu_position'		=> 5,
			'supports'			=> array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'has_archive'		=> false,
		);
		register_post_type( 'shared_region', $args );
	}
	add_action( 'init', 'shared_region_post' );



	/* ========================================================================================================================
	
	Scripts
	
	======================================================================================================================== */

	/**
	 * Add scripts via wp_head()
	 *
	 * @return void
	 * @author Keir Whitaker
	 */

	function starkers_script_enqueuer() {
		wp_register_script( 'site', get_template_directory_uri().'/js/site.js', array( 'jquery' ) );
		wp_enqueue_script( 'site' );

		wp_register_style( 'screen', get_stylesheet_directory_uri().'/style.css', '', '', 'screen' );
        wp_enqueue_style( 'screen' );
	}	


	/* ========================================================================================================================
	
	Comments
	
	======================================================================================================================== */

	/**
	 * Custom callback for outputting comments 
	 *
	 * @return void
	 * @author Keir Whitaker
	 */
	function starkers_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment; 
		?>
		<?php if ( $comment->comment_approved == '1' ): ?>	
		<li>
			<article id="comment-<?php comment_ID() ?>">
				<?php echo get_avatar( $comment ); ?>
				<h4><?php comment_author_link() ?></h4>
				<time><a href="#comment-<?php comment_ID() ?>" pubdate><?php comment_date() ?> at <?php comment_time() ?></a></time>
				<?php comment_text() ?>
			</article>
		<?php endif;
	}