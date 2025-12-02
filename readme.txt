=== WebJIVE Simple Disable Comments ===
Contributors: webjive
Tags: comments, disable comments, remove comments, block comments, spam
Requires at least: 5.0
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.0.3
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Completely disables comments functionality in WordPress. Zero configuration needed. Enhanced by WebJIVE.

== Description ==

WebJIVE Simple Disable Comments is a lightweight plugin that completely disables all comments functionality across your entire WordPress site with no configuration needed. Simply activate and forget.

Forked from BeAPI/disable-comments and enhanced by [WebJIVE Digital Marketing](https://web-jive.com) for improved reliability and code quality.

= Features =

**Core Functionality**
* Disables comments on all post types
* Closes comments and trackbacks/pingbacks
* Hides existing comments from displaying

**Admin Interface**
* Removes Comments menu
* Redirects comment page access
* Removes admin bar comment links
* Removes dashboard metaboxes
* Shows activation notice

**API & Security**
* Disables REST API comment endpoints
* Blocks XML-RPC comment methods
* Removes X-Pingback header

**Block Editor**
* Disables all 15 comment-related Gutenberg blocks

**Multisite Compatible**
* Full WordPress Multisite support

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/`
2. Activate through the 'Plugins' menu
3. Comments are now disabled site-wide

== Frequently Asked Questions ==

= Will this delete my existing comments? =

No. This plugin only hides comments and prevents new ones. Your existing comments remain in the database.

= Does this work with custom post types? =

Yes, it works with all post types including custom ones.

= Is it compatible with WordPress Multisite? =

Yes, fully compatible with Multisite installations.

== Changelog ==

= 1.0.3 =
* Updated plugin name to "WebJIVE Simple Disable Comments" for better branding
* Changed Plugin URI to web-jive.com for fixes and contributions
* Enhanced activation notice with link back to WebJIVE
* Updated author information to "WebJIVE - Digital Marketing Agency"
* Improved plugin header documentation

= 1.0.2 =
* Fixed file existence check before enqueuing JavaScript
* Added version constant for better cache busting
* Added text domain loading for translations support
* Fixed multisite property check for improved error handling
* Updated all branding to WebJIVE
* Added activation notice for user feedback
* Added activation hook
* Created uninstall.php for proper cleanup
* Improved JavaScript with error handling and browser polyfills
* Enhanced code documentation and quality

= 1.0.1 =
* Fix Update URI to prevent false update notifications

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 1.0.3 =
Branding update: Plugin name now displays as "WebJIVE Simple Disable Comments" with proper attribution.

= 1.0.2 =
Major code quality improvements, bug fixes, and better error handling. Recommended update for all users.
