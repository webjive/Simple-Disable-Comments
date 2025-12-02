/**
 * Unregister comment-related Gutenberg blocks.
 *
 * @package SimpleDisableComments
 */

( function() {
	'use strict';

	// Polyfill for Array.prototype.forEach for older browsers.
	if ( ! Array.prototype.forEach ) {
		Array.prototype.forEach = function( callback, thisArg ) {
			if ( this === null || this === undefined ) {
				throw new TypeError( 'Array.prototype.forEach called on null or undefined' );
			}
			if ( typeof callback !== 'function' ) {
				throw new TypeError( callback + ' is not a function' );
			}
			var T, k;
			var O = Object( this );
			var len = O.length >>> 0;
			T = thisArg;
			k = 0;
			while ( k < len ) {
				var kValue;
				if ( k in O ) {
					kValue = O[ k ];
					callback.call( T, kValue, k, O );
				}
				k++;
			}
		};
	}

	// Wait for the blocks to be registered.
	wp.domReady( function() {
		// Check if required WordPress APIs are available.
		if ( ! wp.blocks || ! wp.data ) {
			if ( window.console && window.console.warn ) {
				console.warn( 'Simple Disable Comments: WordPress block APIs are not available.' );
			}
			return;
		}

		// List of comment-related blocks to unregister.
		var commentsBlocks = [
			'core/comment-author-name',
			'core/comment-content',
			'core/comment-date',
			'core/comment-edit-link',
			'core/comment-reply-link',
			'core/comment-template',
			'core/comments',
			'core/comments-pagination',
			'core/comments-pagination-next',
			'core/comments-pagination-numbers',
			'core/comments-pagination-previous',
			'core/comments-title',
			'core/latest-comments',
			'core/post-comments',
			'core/post-comments-form',
		];

		var unregisteredCount = 0;

		// Unregister each comment block if it exists.
		commentsBlocks.forEach( function( blockName ) {
			try {
				if ( wp.data.select( 'core/blocks' ).getBlockType( blockName ) ) {
					wp.blocks.unregisterBlockType( blockName );
					unregisteredCount++;
				}
			} catch ( error ) {
				if ( window.console && window.console.error ) {
					console.error( 'Simple Disable Comments: Error unregistering block ' + blockName, error );
				}
			}
		} );

		// Log success message if in debug mode.
		if ( window.console && window.console.log && unregisteredCount > 0 ) {
			console.log( 'Simple Disable Comments: Successfully unregistered ' + unregisteredCount + ' comment blocks.' );
		}
	} );
} )();
