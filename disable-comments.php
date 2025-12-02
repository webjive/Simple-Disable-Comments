<?php
/**
 * Plugin Name: Simple Disable Comments
 * Plugin URI: https://github.com/webjive/Simple-Disable-Comments
 * Description: Completely disables comments functionality in WordPress. Zero configuration needed.
 * Version: 1.0.2
 * Requires at least: 5.0
 * Requires PHP: 7.4
 * Author: WebJIVE
 * Author URI: https://web-jive.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: disable-comments
 * Domain Path: /languages
 * Update URI: https://github.com/webjive/Simple-Disable-Comments/releases/latest
 *
 * Forked from BeAPI/disable-comments
 * Original inspiration by:
 * - Disable Comments plugin: https://wordpress.org/plugins/disable-comments/
 * - WPBeginner Tutorial: https://www.wpbeginner.com/wp-tutorials/how-to-completely-disable-comments-in-wordpress/
 *
 * @package SimpleDisableComments
 */

namespace WebJIVE\SimpleDisableComments;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Define plugin version.
define( 'SIMPLE_DISABLE_COMMENTS_VERSION', '1.0.2' );

/**
 * Initialize WordPress hooks.
 *
 * @since 1.0.0
 *
 * @return void
 */
function init() {
	// Load text domain for translations.
	add_action( 'init', __NAMESPACE__ . '\\load_textdomain' );

	// Disable support for comments and trackbacks in post types.
	add_action( 'admin_init', __NAMESPACE__ . '\\disable_comments_post_types_support' );

	// Close comments on the front-end.
	add_filter( 'comments_open', '__return_false', 20, 2 );
	add_filter( 'pings_open', '__return_false', 20, 2 );

	// Hide existing comments.
	add_filter( 'comments_array', '__return_empty_array', 10, 2 );

	// Remove comments page in menu.
	add_action( 'admin_menu', __NAMESPACE__ . '\\remove_comments_menu' );

	// Redirect any user trying to access comments page.
	add_action( 'admin_init', __NAMESPACE__ . '\\redirect_comments_page' );

	// Remove comments links from admin bar.
	add_action( 'template_redirect', __NAMESPACE__ . '\\remove_admin_bar_comments' );
	add_action( 'admin_init', __NAMESPACE__ . '\\remove_admin_bar_comments' );

	// Remove comments metabox from dashboard.
	add_action( 'admin_init', __NAMESPACE__ . '\\remove_dashboard_comments_metabox' );

	// Remove comments column from posts list.
	add_action( 'admin_init', __NAMESPACE__ . '\\remove_comments_column' );

	// Remove comment count from "Right Now" dashboard widget.
	add_action( 'wp_dashboard_setup', __NAMESPACE__ . '\\remove_comments_dashboard' );

	// Remove Recent Comments widget.
	add_action( 'widgets_init', __NAMESPACE__ . '\\remove_recent_comments_widget' );

	// Remove comments feed.
	add_action( 'template_redirect', __NAMESPACE__ . '\\disable_comments_feed', 9 );

	// Remove comment-reply script.
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\remove_comment_reply_script', 100 );

	// Remove X-Pingback header.
	add_filter( 'wp_headers', __NAMESPACE__ . '\\remove_pingback_header' );

	// Disable XML-RPC methods for comments and pingbacks.
	add_filter( 'xmlrpc_methods', __NAMESPACE__ . '\\disable_xmlrpc_methods' );

	// Disable Comments REST API Endpoint.
	add_filter( 'rest_endpoints', __NAMESPACE__ . '\\filter_rest_endpoints' );

	// Disable inserting comments via REST API.
	add_filter( 'rest_pre_insert_comment', __NAMESPACE__ . '\\__return_null', 10, 2 );

	// Disable Gutenberg comments blocks.
	add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\\disable_comments_blocks' );

	// Add admin notice on activation.
	add_action( 'admin_notices', __NAMESPACE__ . '\\activation_notice' );
}

/**
 * Load plugin text domain for translations.
 *
 * @since 1.0.2
 *
 * @return void
 */
function load_textdomain() {
	load_plugin_textdomain(
		'disable-comments',
		false,
		dirname( plugin_basename( __FILE__ ) ) . '/languages'
	);
}

/**
 * Display admin notice after activation.
 *
 * @since 1.0.2
 *
 * @return void
 */
function activation_notice() {
	$screen = get_current_screen();
	if ( 'plugins' === $screen->id && get_transient( 'simple_disable_comments_activated' ) ) {
		?>
		<div class="notice notice-success is-dismissible">
			<p><?php esc_html_e( 'Simple Disable Comments is now active. All comment functionality has been disabled across your site.', 'disable-comments' ); ?></p>
		</div>
		<?php
		delete_transient( 'simple_disable_comments_activated' );
	}
}

/**
 * Disable comments and trackbacks support for all post types.
 *
 * @since 1.0.0
 *
 * @return void
 */
function disable_comments_post_types_support() {
	$post_types = get_post_types();

	foreach ( $post_types as $post_type ) {
		if ( post_type_supports( $post_type, 'comments' ) ) {
			remove_post_type_support( $post_type, 'comments' );
			remove_post_type_support( $post_type, 'trackbacks' );
		}
	}
}

/**
 * Remove comments menu from admin.
 *
 * @since 1.0.0
 *
 * @return void
 */
function remove_comments_menu() {
	remove_menu_page( 'edit-comments.php' );
}

/**
 * Redirect users trying to access comments page.
 *
 * @since 1.0.0
 *
 * @return void
 */
function redirect_comments_page() {
	global $pagenow;

	if ( 'edit-comments.php' === $pagenow ) {
		wp_safe_redirect( admin_url() );
		exit;
	}
}

/**
 * Remove comments links from admin bar.
 *
 * @since 1.0.0
 *
 * @return void
 */
function remove_admin_bar_comments() {
	if ( is_admin_bar_showing() ) {
		remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );

		if ( is_multisite() ) {
			add_action( 'admin_bar_menu', __NAMESPACE__ . '\\remove_network_comment_links', 500 );
		}
	}
}

/**
 * Remove comment links from the admin bar in a multisite network.
 *
 * @since 1.0.0
 *
 * @param \WP_Admin_Bar $wp_admin_bar The WP_Admin_Bar instance.
 * @return void
 */
function remove_network_comment_links( $wp_admin_bar ) {
	if ( is_user_logged_in() ) {
		if ( isset( $wp_admin_bar->user->blogs ) && is_array( $wp_admin_bar->user->blogs ) ) {
			foreach ( $wp_admin_bar->user->blogs as $blog ) {
				$wp_admin_bar->remove_menu( 'blog-' . $blog->userblog_id . '-c' );
			}
		}
	} else {
		// We have no way to know whether the plugin is active on other sites, so only remove this one.
		$wp_admin_bar->remove_menu( 'blog-' . get_current_blog_id() . '-c' );
	}
}

/**
 * Remove comments metabox from dashboard.
 *
 * @since 1.0.0
 *
 * @return void
 */
function remove_dashboard_comments_metabox() {
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
}

/**
 * Remove comments column from post types.
 *
 * @since 1.0.0
 *
 * @return void
 */
function remove_comments_column() {
	$post_types = get_post_types();

	foreach ( $post_types as $post_type ) {
		add_filter( "manage_{$post_type}_posts_columns", __NAMESPACE__ . '\\remove_column_callback' );
	}
}

/**
 * Callback to remove comments column.
 *
 * @since 1.0.0
 *
 * @param array $columns The columns array.
 * @return array Modified columns array.
 */
function remove_column_callback( $columns ) {
	unset( $columns['comments'] );
	return $columns;
}

/**
 * Remove comments from dashboard "At a Glance" widget.
 *
 * @since 1.0.0
 *
 * @return void
 */
function remove_comments_dashboard() {
	remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
}

/**
 * Unregister Recent Comments widget.
 *
 * @since 1.0.0
 *
 * @return void
 */
function remove_recent_comments_widget() {
	unregister_widget( 'WP_Widget_Recent_Comments' );

	// Remove inline style added by Recent Comments widget.
	add_filter( 'show_recent_comments_widget_style', '__return_false' );
}

/**
 * Disable comments feed.
 *
 * @since 1.0.0
 *
 * @return void
 */
function disable_comments_feed() {
	if ( is_comment_feed() ) {
		wp_die(
			esc_html__( 'Comments are disabled.', 'disable-comments' ),
			esc_html__( 'Comments Disabled', 'disable-comments' ),
			array( 'response' => 403 )
		);
	}
}

/**
 * Remove comment-reply script.
 *
 * @since 1.0.0
 *
 * @return void
 */
function remove_comment_reply_script() {
	wp_deregister_script( 'comment-reply' );
}

/**
 * Remove X-Pingback header.
 *
 * @since 1.0.0
 *
 * @param array $headers The headers array.
 * @return array Modified headers array.
 */
function remove_pingback_header( $headers ) {
	unset( $headers['X-Pingback'] );
	return $headers;
}

/**
 * Disable XML-RPC methods for comments and pingbacks.
 *
 * @since 1.0.0
 *
 * @param array $methods The XMLRPC methods array.
 * @return array Modified methods array.
 */
function disable_xmlrpc_methods( $methods ) {
	unset( $methods['pingback.ping'] );
	unset( $methods['pingback.extensions.getPingbacks'] );
	unset( $methods['wp.newComment'] );
	return $methods;
}

/**
 * Remove the comments endpoint for the REST API.
 *
 * @since 1.0.0
 *
 * @param array $endpoints The available REST API endpoints.
 * @return array Modified endpoints array.
 */
function filter_rest_endpoints( $endpoints ) {
	if ( isset( $endpoints['comments'] ) ) {
		unset( $endpoints['comments'] );
	}
	if ( isset( $endpoints['/wp/v2/comments'] ) ) {
		unset( $endpoints['/wp/v2/comments'] );
	}
	if ( isset( $endpoints['/wp/v2/comments/(?P<id>[\d]+)'] ) ) {
		unset( $endpoints['/wp/v2/comments/(?P<id>[\d]+)'] );
	}
	return $endpoints;
}

/**
 * Disable Gutenberg comments blocks.
 * Enqueues JavaScript to unregister all comment-related blocks from the block editor.
 *
 * @since 1.0.0
 *
 * @return void
 */
function disable_comments_blocks() {
	$script_path = plugin_dir_path( __FILE__ ) . 'assets/disable-comments-blocks.js';
	
	if ( file_exists( $script_path ) ) {
		wp_enqueue_script(
			'disable-comments-blocks',
			plugin_dir_url( __FILE__ ) . 'assets/disable-comments-blocks.js',
			array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),
			SIMPLE_DISABLE_COMMENTS_VERSION,
			true
		);
	}
}

/**
 * Activation hook.
 *
 * @since 1.0.2
 *
 * @return void
 */
function activate() {
	set_transient( 'simple_disable_comments_activated', true, 30 );
}

register_activation_hook( __FILE__, __NAMESPACE__ . '\\activate' );

// Initialize the plugin.
init();
