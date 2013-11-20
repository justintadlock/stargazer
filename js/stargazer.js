jQuery( document ).ready( function() {

	/*
	 * Theme fonts handler.  This is so that child themes can make sure to style for future changes.  If 
	 * they add styles for `.font-primary`, `.font-secondary`, and `.font-headlines`, users will always 
	 * get the correct styles, even if the parent theme adds extra items.
	 *
	 * Child theme should still incorporate the normal selectors in theis `style.css`.  This is just for 
	 * additional future-proofing.
	 */

	var font_primary = 'body, input, textarea, .label-checkbox, .label-radio, .required, #site-description, #reply-title small';

	var font_secondary = 'dt, th, legend, label, input[type="submit"], input[type="reset"], input[type="button"], button, select, option, .wp-caption-text, .gallery-caption, .mejs-controls, .entry-byline, .entry-footer, .chat-author cite, .chat-author, .comment-meta, .breadcrumb-trail, .menu, .media-info .prep, .comment-reply-link, .comment-reply-login, .clean-my-archives .day, .whistle-title';

	var font_headlines = 'h1, h2, h3, h4, h5, h6';

	jQuery( font_primary ).addClass( 'font-primary' );
	jQuery( font_secondary ).addClass( 'font-secondary' );
	jQuery( font_headlines ).not( '#site-description' ).addClass( 'font-headlines' );

	/*
	 * Adds classes to the `<label>` element based on the type of form element the label belongs 
	 * to. This allows theme devs to style specifically for certain labels (think, icons).
	 */

	jQuery( '#container input, #container textarea, #container select' ).each(

		function() {
			var sg_input_type = 'input';
			var sg_input_id   = jQuery( this ).attr( 'id' );
			var sg_label      = '';

			if ( jQuery( this ).is( 'input' ) )
				sg_input_type = jQuery( this ).attr( 'type' );

			else if ( jQuery( this ).is( 'textarea' ) )
				sg_input_type = 'textarea';

			else if ( jQuery( this ).is( 'select' ) )
				sg_input_type = 'select';

			jQuery( this ).parent( 'label' ).addClass( 'label-' + sg_input_type );

			if ( sg_input_id )
				jQuery( 'label[for="' + sg_input_id + '"]' ).addClass( 'label-' + sg_input_type );

			if ( 'checkbox' === sg_input_type || 'radio' === sg_input_type ) {
				jQuery( this ).parent( 'label' ).removeClass( 'font-secondary' ).addClass( 'font-primary' );

				if ( sg_input_id )
					jQuery( 'label[for="' + sg_input_id + '"]' ).removeClass( 'font-secondary' ).addClass( 'font-primary' );

			}
		}
	);

	/*
	 * Handles situations in which CSS `:contain()` would be extremely useful. Since that doesn't actually 
	 * exist or is not supported by browsers, we have the following.
	 */

	/* Adds the 'has-cite' class to the parent element in a blockquote that wraps <cite>, such as a <p>. */
	jQuery( 'blockquote p' ).has( 'cite' ).addClass( 'has-cite' );

	/*
	 * Adds the `.has-cite-only` if the last `<p>` in the `<blockquote>` only has the `<cite>` element.
	 * Adds the `.is-last-child` class to the previous `<p>`.  This is so that we can style correctly 
	 * for blockquotes in English, in which only the last paragraph should have a closing quote.
	 */
	jQuery( 'blockquote p:has( cite )' ).filter(
		function() {
			if ( 1 === jQuery( this ).contents().length ) {
				jQuery( this ).addClass( 'has-cite-only' );
				jQuery( this ).prev( 'p' ).addClass( 'is-last-child' );
			}
		}
	);


	/* Add class to links with an image. */
	jQuery( 'a' ).has( 'img' ).addClass( 'img-hyperlink' );

	/* Adds 'has-posts' to any <td> element in the calendar that has posts for that day. */
	jQuery( '.wp-calendar tbody td' ).has( 'a' ).addClass( 'has-posts' );

	/*
	 * Menu and search form toggles.
	 */

	jQuery( '.menu-toggle' ).click(
		function() {
			jQuery( this ).parent().children( '.wrap' ).fadeToggle();
			jQuery( this ).toggleClass( 'active' );
		}
	);

	jQuery( '#menu-primary .search-form' ).wrapInner( '<div />' ).prepend( '<a class="toggle">&nbsp;</a>' );

	jQuery( window ).resize(
		function() {
			var width = jQuery( window ).width();

			if ( 800 <= width ) {
				jQuery( '#menu-primary .search-form > div' ).hide();
				jQuery( '.menu-toggle' ).removeClass( 'active' )
			} else {
				jQuery( '#menu-primary .search-form > div' ).show();
				jQuery( '.menu > .wrap:visible' ).parent().children( '.menu-toggle' ).addClass( 'active' );
			}
		}
	);

	jQuery( 'html' ).click(
		function( event ) {
			if ( jQuery( event.target ).hasClass( 'menu-toggle' ) ) {
				jQuery( '#menu-primary .search-form > div' ).show( 'slow' );

			} else if ( !jQuery( '.menu-toggle' ).hasClass( 'active' ) ) {
				jQuery( '#menu-primary .search-form > div' ).hide( 'slow' );
			}
		}
	);

	jQuery( '#menu-primary .search-form' ).click(
		function( event ) {
			event.stopPropagation();
		}
	);

	jQuery( '#menu-primary .search-form a.toggle' ).click(
		function() {
			jQuery( '#menu-primary .search-form > div' ).toggle( 'slow' );
		}
	);

	/*
	 * Adding special HTML on some elements.
	 */

	/* Adds a `<span class="wrap">` around some elements. */
	jQuery(
		'.widget-title, #comments-number, #reply-title, .attachment-meta-title' 
	).wrapInner( '<span class="wrap" />' );

	/* Adds <span class="screen-reader-text"> on some elements. */
	jQuery( '.widget-widget_rss .widget-title img' ).wrap( '<span class="screen-reader-text" />' );

	jQuery( 
		'.breadcrumb-trail a[rel="home"], .breadcrumb-trail .sep, .author-box .social a'
	).wrapInner( '<span class="screen-reader-text" />' );

	/*
	 * Video and other embeds.  Let's make them more responsive.	
	 */

	/* Overrides WP's <div> wrapper around videos, which mucks with flexible videos. */
	jQuery( 'div[style*="max-width: 100%"] > video' ).parent().css( 'width', '100%' );

	/* Responsive videos. */
	/* blip.tv adds a second <embed> with "display: none".  We don't want to wrap that. */
	jQuery( 'object, embed, iframe' ).not( 'embed[style*="display"], [src*="soundcloud.com"]' ).wrap( '<div class="embed-wrap" />' );

	/* Removes the 'width' attribute from embedded videos and replaces it with a max-width. */
	jQuery( '.embed-wrap object, .embed-wrap embed, .embed-wrap iframe' ).attr( 
		'width',
		function( index, value ) {
			jQuery( this ).attr( 'style', 'max-width: ' + value + 'px;' );
			jQuery( this ).removeAttr( 'width' );
		}
	);

	/* Toggles audio/video info when using the [audio] or [video] shortcode. */
	jQuery( '.media-info-toggle' ).click(
		function() {
			jQuery( this ).parent().children( '.audio-info, .video-info' ).slideToggle( 'slow' );
			jQuery( this ).toggleClass( 'active' );
		}
	);

} );