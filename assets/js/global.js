


(
	
	function( $ ) {
	/*
	 * Test if inline SVGs are supported.
	 * @link https://github.com/Modernizr/Modernizr/
	 */
	function supportsInlineSVG() {
		var div = document.createElement( 'div' );
		div.innerHTML = '<svg/>';
		return 'http://www.w3.org/2000/svg' === ( 'undefined' !== typeof SVGRect && div.firstChild && div.firstChild.namespaceURI );
	}

	/**
	 * Test if an iOS device.
	*/
	function checkiOS() {
		return /iPad|iPhone|iPod/.test(navigator.userAgent) && ! window.MSStream;
	}

	$(document).on('click', '.show-form', function() {
		$('#author_info').toggle(300);
	});

	function g($) {
        return ($.which > 0 || "mousedown" === $.type || "mousewheel" === $.type) && f.stop().off("scroll mousedown DOMMouseScroll mousewheel keyup", g);
	}

	var f = $("html, body");
	$(".scroll-to-top").on("click touchstart touchend", function ($) {
		$.preventDefault();
		f.on("scroll mousedown DOMMouseScroll mousewheel keyup", g);
		f.animate({
			scrollTop: 0
		}, 1000, function () {
			f.stop().off("scroll mousedown DOMMouseScroll mousewheel keyup", g);
		});
	});

	// Fire on document ready.
	$( document ).ready( function() {

		if ( true !== supportsInlineSVG() ) {
			document.documentElement.className = document.documentElement.className.replace( /(\s*)svg(\s*)/, '$1no-svg$2' );
			$('#svg-warnning').removeClass('hidden');
			$('#svg-warnning').fadeOut(5000, function(){
				$('#svg-warnning').addClass('hidden');
			});
		}

		if ( $('.show-form').length > 0 ){
			$('#author_info').toggle(10);
		}

	});

	$(window).scroll(function () {
		if ($(this).scrollTop() > 100) {
			$('.scroll-to-top').fadeIn();
		} else {
			$('.scroll-to-top').fadeOut();
		}
	});

})( jQuery );
	
	
