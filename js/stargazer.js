jQuery( document ).ready(

	function() {

		var font_primary = 'body, input, textarea, .label-checkbox, .label-radio, .required, #site-description, #reply-title small';

		var font_secondary = 'dt, th, legend, label, input[type="submit"], input[type="reset"], input[type="button"], button, select, option, .wp-caption-text, .gallery-caption, .mejs-controls, .entry-byline, .entry-footer, .chat-author cite, .chat-author, .comment-meta, nav, .menu, .media-info .prep, .comment-reply-link, .comment-reply-login, .clean-my-archives .day, .whistle-title';

		var font_headlines = 'h1, h2, h3, h4, h5, h6';

		jQuery( font_primary ).addClass( 'font-primary' );
		jQuery( font_secondary ).addClass( 'font-secondary' );
		jQuery( font_headlines ).not( '#site-description' ).addClass( 'font-headlines' );

		/* Adds classes to the <label> element based on the <input> type the label belongs to. */

		jQuery( '#container input, #container textarea, #container select' ).each(

			function() {
				var sg_input_type = '';
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
			}
		);


		//jQuery( '.menu-item:has( > ul )' ).find( '> a:first-child' ).after( '<a class="menu-toggle-children">&darr;</a>' );

		/* == replicates what CSS ":contain()" should do for us === */

		/* Adds the 'has-cite' class to the parent element in a blockquote that wraps <cite>, such as a <p>. */
		jQuery( 'blockquote p' ).has( 'cite' ).addClass( 'has-cite' );

		jQuery( 'blockquote p:has( cite )' ).filter(
			function() {
				if ( jQuery( this ).contents().length === 1 ) {
					jQuery( this ).addClass( 'has-cite-only' );
					jQuery( this ).prev( 'p' ).addClass( 'is-last-child' );
				}
			}
		);


		/* Add class to links with an image. */
		jQuery( 'a' ).has( 'img' ).addClass( 'img-hyperlink' );

		/* Adds 'has-posts' to any <td> element in the calendar that has posts for that day. */
		jQuery( '.wp-calendar tbody td' ).has( 'a' ).addClass( 'has-posts' );

		/* =/=/= */

		// http://patrickhaney.com/thinktank/2008/08/19/automatic-awesompersands
		jQuery( "*:contains('&')", document.body ).not( 'code, pre, tt, kbd, var, sup, sub' ).contents().each(
			function() {
				if ( 3 === this.nodeType ) {
					jQuery( this ).replaceWith( this.nodeValue.replace( /&/g, '<span class="amp">&</span>' ) );
				}
			}
		);

		/* Search form toggle. */
		jQuery( '#menu-primary .search-form' ).wrapInner( '<div />' ).prepend( '<a class="toggle">&nbsp;</a>' );
		jQuery( '#menu-primary .search-form > div' ).hide();

		jQuery( 'html' ).click(
			function() {
				jQuery( '#menu-primary .search-form > div' ).hide( 'slow' );
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

		jQuery(
			'.widget-title, #comments-number, #reply-title, .attachment-meta-title' 
		).wrapInner( '<span class="wrap" />' );

		jQuery( '.widget-widget_rss .widget-title img' ).wrap( '<span class="screen-reader-text" />' );

		/* Adds <span class="screen-reader-text"> on some elements. */
		jQuery( 
			'.breadcrumb-trail a[rel="home"], .breadcrumb-trail .sep, .author-box .social a'
		).wrapInner( '<span class="screen-reader-text" />' );

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


		/* Tabs. */
/*
		jQuery( '.comment-list' ).hide();
		jQuery( '.comment-list:first-of-type' ).show();
		jQuery( '.comments-tab-nav :first-child' ).attr( 'aria-selected', 'true' );

		jQuery( '.comments-tab-nav a' ).click(
			function( j ) {
				j.preventDefault();

				var href = jQuery( this ).attr( 'href' );

				jQuery( this ).parents( '#comments' ).find( '.comment-list' ).hide();

				jQuery( this ).parents( '#comments' ).find( href ).show();

				jQuery( this ).parents( '#comments' ).find( '.comments-number' ).attr( 'aria-selected', 'false' );

				jQuery( this ).parent().attr( 'aria-selected', 'true' );
			}
		);
*/
	}
);