<?php
/**
 * Uninstall script for Simple Disable Comments.
 *
 * This file is triggered when the plugin is deleted via the WordPress admin.
 *
 * @package SimpleDisableComments
 */

// If uninstall not called from WordPress, exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Clean up any transients set by the plugin.
delete_transient( 'simple_disable_comments_activated' );

// Note: This plugin doesn't store any options or modify the database,
// so there's minimal cleanup needed. Existing comments remain in the database
// and will be visible again if another comments plugin is activated.
