!function(i){var t=1500;ua=navigator.userAgent,(ua.indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(t=5e3),i("body").hasClass("et-fb")&&(t=1e4),setTimeout(function(){if(0!==i(".tina_girl_testimonial ").length){i(".tina_girl_testimonial .girl_testimonial_arr").each(function(){i(this).html("<span></span>")});var t=2;i(window).width()<=767&&(t=1);var e=i(".tina_girl_testimonial .girl_testimonial_slider_row").width(),_=i(".tina_girl_testimonial .girl_testimonial_slider_row .et_pb_testimonial").length,l=i(".tina_girl_testimonial .girl_testimonial_slider_row .et_pb_testimonial").css("margin-right"),a=(e-(l=parseInt(l,10)))/t;i(".tina_girl_testimonial .girl_testimonial_slider_row .et_pb_testimonial ").outerWidth(a),i(".tina_girl_testimonial .girl_testimonial_slider_row .et_pb_column ").css("cssText","width: "+((a+l)*_+10)+"px !important;"),i(".tina_girl_testimonial .girl_testimonial_slider_row .et_pb_testimonial:first-child").addClass("active_item"),i(".tina_girl_testimonial .girl_testimonial_arr_right").on("click",function(e){e.preventDefault(),i(".tina_girl_testimonial .girl_testimonial_slider_row .et_pb_testimonial.active_item").nextAll().length>=t?i(".tina_girl_testimonial .girl_testimonial_slider_row .et_pb_testimonial.active_item").removeClass("active_item").next().addClass("active_item"):(i(".tina_girl_testimonial .girl_testimonial_slider_row .et_pb_testimonial.active_item").removeClass("active_item"),i(".tina_girl_testimonial .girl_testimonial_slider_row .et_pb_testimonial:first-child").addClass("active_item"))}),i(".tina_girl_testimonial .girl_testimonial_arr_left").on("click",function(e){e.preventDefault(),0!==i(".tina_girl_testimonial .girl_testimonial_slider_row .et_pb_testimonial.active_item").prev().length?i(".tina_girl_testimonial .girl_testimonial_slider_row .et_pb_testimonial.active_item").removeClass("active_item").prev().addClass("active_item"):(i(".tina_girl_testimonial .girl_testimonial_slider_row .et_pb_testimonial.active_item").removeClass("active_item"),i(".tina_girl_testimonial .girl_testimonial_slider_row .et_pb_testimonial:nth-last-child("+t+")").addClass("active_item"))}),i(".tina_girl_testimonial .girl_testimonial_arr").on("click",function(t){setTimeout(function(){var t=i(".tina_girl_testimonial .girl_testimonial_slider_row .et_pb_testimonial.active_item").prevAll().length;i(".tina_girl_testimonial .girl_testimonial_slider_row .et_pb_column").css("transform","translateX(-"+t*(l+a)+"px)")},50)});var n=0;i(".tina_girl_testimonial .girl_testimonial_slider_row .et_pb_testimonial").each(function(){n<i(this).outerHeight()&&(n=i(this).outerHeight())}),i(".tina_girl_testimonial .girl_testimonial_slider_row .et_pb_testimonial").outerHeight(n)}},t)}(jQuery);