!function(e){var n=500;ua=navigator.userAgent,(ua.indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(n=5e3),e("body").hasClass("et-fb")&&(n=1e4),setTimeout(function(){0!==e(".ragnar_header_son").length&&e(".ragnar_header_son .et_pb_number_counter").each(function(){var n=e(this).css("background-image").replace(/^url\(['"](.+)['"]\)/,"$1");e(this).css("cssText","background-image: none !important"),e(this).prepend(e('<div class="counter_image"><img src="'+n+'"></div>'))})},n)}(jQuery);