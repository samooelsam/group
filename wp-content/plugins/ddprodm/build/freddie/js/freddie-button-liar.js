!function(e){var t=1e3;ua=navigator.userAgent,(ua.indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(t=5e3),e("body").hasClass("et-fb")&&(t=1e4),setTimeout(function(){e('<div class="line"></div>').appendTo(e(".et_pb_button_module_wrapper .et_pb_button.freddie_button_liar"));var t=new TimelineLite;e(".et_pb_button_module_wrapper .et_pb_button.freddie_button_liar").hover(function(){var i=e(this).find(".line");t.to(e(this),.4,{x:"10px",ease:Power3.easeInOut},0).to(i,.4,{width:"27px",opacity:1,ease:Power3.easeInOut},0)},function(){t.clear();var i=e(this).find(".line");(new TimelineLite).to(e(this),.4,{x:"0",ease:Power3.easeInOut},0).to(i,.4,{width:"100%",opacity:.2,ease:Power3.easeInOut},0)})},t)}(jQuery);