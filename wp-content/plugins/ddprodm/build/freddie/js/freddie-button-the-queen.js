!function(e){var t=1e3;ua=navigator.userAgent,(ua.indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(t=5e3),e("body").hasClass("et-fb")&&(t=1e4),setTimeout(function(){e(".et_pb_button_module_wrapper .et_pb_button.freddie_button_the_queen ").each(function(){var t=e(this).text();e(this).html("<span>"+t+"</span>");var i=e(this).css("background-image").replace("url(","").replace(")","").replace(/\"/gi,"");e(this).css("cssText","background-image: none !important"),e(this).prepend(e('<div class="button_bg"></div>')),e(this).prepend(e('<div class="button_image"><img src="'+i+'"></div>'))}),e(".et_pb_button_module_wrapper .et_pb_button.freddie_button_the_queen ").hover(function(){this.tlFatBottomedCircle=new TimelineLite,this.tlFatBottomedCircle.to(e(this).find("span"),.2,{y:0,ease:Linear.easeNone},.2).to(e(this).find(".button_bg"),.2,{scale:1,borderRadius:0,ease:Linear.easeNone},0).to(e(this).find(".button_image"),.2,{y:1,top:31,ease:Linear.easeNone},.2),this.tlFatBottomedCircle.play()},function(){this.tlFatBottomedCircle.reverse()})},t)}(jQuery);