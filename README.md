# WebJIVE Simple Disable Comments

A simple and lightweight WordPress plugin that completely disables comments functionality across your entire WordPress site.

## Description

This plugin disables all comments functionality in WordPress with no configuration needed. Simply activate the plugin and all comment features will be disabled.

**Forked from BeAPI/disable-comments** - Enhanced and maintained by [WebJIVE Digital Marketing](https://web-jive.com).

## Features

### Core Functionality
- Disables comments on all post types (posts, pages, attachments, custom post types)
- Closes comments and trackbacks/pingbacks on the front-end
- Hides existing comments from displaying

### Admin Interface
- Removes Comments menu from admin sidebar
- Redirects users trying to access the comments page
- Removes comments from admin bar (front-end and back-end)
- Removes comments metabox from dashboard
- Removes "At a Glance" dashboard widget with comment count
- Removes comments column from posts list
- Shows activation notice when plugin is enabled

### Widgets & Scripts
- Removes Recent Comments widget
- Removes comment-reply script from front-end

### RSS & Feeds
- Disables comments feed (returns 403 error)
- Removes X-Pingback header from HTTP responses

### API & XML-RPC
- Disables XML-RPC methods for comments and pingbacks
  - `pingback.ping`
  - `pingback.extensions.getPingbacks`
  - `wp.newComment`
- Disables WordPress REST API comments endpoints
  - `/wp/v2/comments`
  - `/wp/v2/comments/{id}`
- Prevents comment insertion via REST API

### Gutenberg Block Editor
- Disables all 15 comment-related Gutenberg blocks:
  - Comment Author Name
  - Comment Content
  - Comment Date
  - Comment Edit Link
  - Comment Reply Link
  - Comment Template
  - Comments
  - Comments Pagination
  - Comments Pagination Next
  - Comments Pagination Numbers
  - Comments Pagination Previous
  - Comments Title
  - Latest Comments
  - Post Comments
  - Post Comments Form

### Multisite Support
- Works on WordPress Multisite installations
- Removes network comment links from admin bar

## Installation

1. Upload the `simple-disable-comments` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. That's it! Comments are now completely disabled

## Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher

## Usage

This plugin works out of the box with no configuration needed. Once activated, all comment functionality will be disabled.

To re-enable comments, simply deactivate the plugin.

## Frequently Asked Questions

### Will this plugin delete existing comments?

No, this plugin does not delete any existing comments from your database. It simply hides them from displaying and prevents new comments from being submitted.

### Can I configure which features to disable?

This plugin is designed to be simple and lightweight with no configuration options. It disables all comment functionality when activated.

### Does this work with custom post types?

Yes, this plugin disables comments for all post types, including custom post types.

### Does this work with WordPress Multisite?

Yes, the plugin is fully compatible with WordPress Multisite installations and will work on individual sites or network-wide.

### Does this disable Gutenberg comment blocks?

Yes, the plugin disables all 15 comment-related Gutenberg blocks, preventing them from being inserted in the block editor.

### Does this block comments via REST API?

Yes, the plugin disables comment endpoints in the WordPress REST API and prevents comment insertion via API requests.

### Does this plugin automatically replace the previous "Disable Comments" plugin from WordPress.org?

Yes, this plugin will automatically replace the original open-source [Disable Comments](https://wordpress.org/plugins/disable-comments/) plugin if you overwrite the old plugin folder with this one. This works because both plugins use the same folder name (`disable-comments`) and main PHP file. No reactivation is required after replacing the files—just copy over the new files and the updated plugin will be used immediately.  
Please note, however, that any options or settings saved by the previous plugin are not removed during this process.

## Changelog

### 1.0.3
* Updated plugin name to "WebJIVE Simple Disable Comments" for better branding
* Changed Plugin URI to web-jive.com
* Enhanced activation notice with link to WebJIVE
* Updated author information to "WebJIVE - Digital Marketing Agency"

### 1.0.2
* Fixed file existence check before enqueuing JavaScript
* Added version constant for better cache busting
* Added text domain loading for translations
* Fixed multisite property check for better error handling
* Updated all branding to WebJIVE
* Added activation notice
* Added activation hook
* Created uninstall.php for proper cleanup
* Improved JavaScript with error handling and polyfills
* Enhanced code quality and documentation

### 1.0.1
* Fix Update URI to not have updates showing

### 1.0.0
* Initial release (BeAPI version)

## License

GPL v2 or later

## Credits

Forked from [BeAPI/disable-comments](https://github.com/BeAPI/disable-comments)

Original inspiration by:
- [Disable Comments plugin](https://wordpress.org/plugins/disable-comments/) - The original WordPress.org plugin
- [WPBeginner Tutorial](https://www.wpbeginner.com/wp-tutorials/how-to-completely-disable-comments-in-wordpress/) - Comprehensive guide on disabling comments

## Author

WebJIVE - Digital Marketing Agency  
Little Rock, Arkansas  
[https://web-jive.com](https://web-jive.com)

## Support

For issues, feature requests, or questions:
- GitHub Issues: [https://github.com/webjive/Simple-Disable-Comments/issues](https://github.com/webjive/Simple-Disable-Comments/issues)
- Email: support@web-jive.com
