( function( $ ) {
	wp.customize( 'blogname', function( value ) {
		value.bind( function( newval ) {
			$( '.site-title a' ).html( newval );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( newval ) {
			$( '.site-description' ).html( newval );
		} );
	} );
	wp.customize( 'logo_text_color', function( value ) {
		value.bind( function( newval ) {
			$('.site-title a,.site-description').css('color', newval );
		} );
	} );
	wp.customize( 'background_color', function( value ) {
		value.bind( function( newval ) {
			$('body').css('background-color', newval );
		} );
	} );
	wp.customize( 'menu_background', function( value ) {
		value.bind( function( newval ) {
			$('nav#menu').css('background', newval );
		} );
	} );
	wp.customize( 'menu_background_hover', function( value ) {
		value.bind( function( newval ) {
			$('nav#menu .active a').css('background', newval );
		} );
	} );
	wp.customize( 'menu_background_hover', function( value ) {
		value.bind( function( newval ) {
			$('nav#menu a:hover').css('background', newval );
		} );
	} );
		wp.customize( 'headers_color', function( value ) {
		value.bind( function( newval ) {
			$('.container-fluid.footer h3').css('background-color', newval);
		} );
	} );
	wp.customize( 'headers_color', function( value ) {
		value.bind( function( newval ) {
			$('.side-widget h3').css('background', newval);
		} );
	} );
	wp.customize( 'headers_text_color', function( value ) {
		value.bind( function( newval ) {
			$('a.learn-more,#footer h3,.footer h3,.side-widget h3 a,.side-widget h3,.nav.nav-tabs li.active a,.col-sm-9 .title h1').css('color', newval);
		} );
	} );
	wp.customize( 'buttons_background_color', function( value ) {
		value.bind( function( newval ) {
			$('.form-button').css('background-color', newval);
		} );
	} );
	wp.customize( 'buttons_background_color', function( value ) {
		value.bind( function( newval ) {
			$('.search-button').css('background-color', newval);
		} );
	} );
	wp.customize( 'buttons_background_color', function( value ) {
		value.bind( function( newval ) {
			$('.detail-btn').css('background-color', newval);
		} );
	} );
		wp.customize( 'search_color_hover', function( value ) {
		value.bind( function( newval ) {
			$('.selectBox.dropdown .selectBox-label:hover').css('color', newval );
		} );
	} );
} )( jQuery );
