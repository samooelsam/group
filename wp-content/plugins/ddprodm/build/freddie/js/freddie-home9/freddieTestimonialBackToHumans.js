!function(e){var t=1500;ua=navigator.userAgent,(ua.indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(t=5e3),e("body").hasClass("et-fb")&&(t=1e4),setTimeout(function(){if(0!==e(".freddie_testimonial_back_to_humans").length){var t="1";e(".freddie_testimonial_back_to_humans  .et_pb_slide").each(function(){var i=e(this).find(".et_pb_slide_image img").attr("src");e(".freddie_testimonial_back_to_humans .et-pb-controllers a:nth-child("+t+")").text(""),e('<img src="'+i+'">').appendTo(e(".freddie_testimonial_back_to_humans .et-pb-controllers a:nth-child("+t+")")),t++,e(this).find(".et_pb_slide_image").css("background-image","url("+e(this).find(".et_pb_slide_image img").attr("src")+")"),e(this).find(".et_pb_slide_image img").remove()});var i=80;e(window).width()<=980&&(i=40),e('<div class="inner_controller"></div>').appendTo(e(".freddie_testimonial_back_to_humans .et_pb_slider .et-pb-controllers"));var _=e(".freddie_testimonial_back_to_humans .et_pb_slider .et_pb_slide_description").css("padding-bottom"),n=(_=parseInt(_,10)-i,e(".freddie_testimonial_back_to_humans .et_pb_slider .et-pb-controllers a").length);e(".freddie_testimonial_back_to_humans .et_pb_slider .et-pb-controllers").width(_),_=e(".freddie_testimonial_back_to_humans .et_pb_slider .et-pb-controllers").width(),e(".freddie_testimonial_back_to_humans .et_pb_slider .et-pb-controllers .inner_controller").width(n*(_/3)),e(".freddie_testimonial_back_to_humans .et-pb-controllers a").each(function(){e(this).appendTo(e(this).closest(".et-pb-controllers").find(".inner_controller")),e(this).outerWidth(_/3-14),e(this).outerHeight(_/3-14)});var s=0;e(".freddie_testimonial_back_to_humans  .et_pb_slide").each(function(){e(this).find(".et_pb_slide_description").outerHeight()>s&&(s=e(this).find(".et_pb_slide_description").outerHeight())}),e(".freddie_testimonial_back_to_humans  .et_pb_slide .et_pb_slide_description").outerHeight(s),e(".freddie_testimonial_back_to_humans .et-pb-controllers a").on("click",function(){var t=e(this);setTimeout(function(){var i=t.prevAll("a").length;1===i||0===i?e(".freddie_testimonial_back_to_humans .et_pb_slider .inner_controller").css("transform","translate(0px, 0px)"):0!==t.nextAll("a").length&&e(".freddie_testimonial_back_to_humans .et_pb_slider .inner_controller").css("transform","translate(-"+_/3*(i-1)+"px, 0px)")},50)})}},t)}(jQuery);