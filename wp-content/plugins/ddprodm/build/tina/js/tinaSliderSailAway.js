!function(e){var t=1500;ua=navigator.userAgent,(ua.indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(t=5e3),e("body").hasClass("et-fb")&&(t=1e4),setTimeout(function(){if(0!==e("body:not(.et-fb) .tina_slider_sail_away").length){e('<div class="arrow-cursor"><svg class="arrow-cursor__icon" viewBox="0 0 117.25 86.75"> <path class="arrow-cursor__path" d="M111.45,42.5,74.65,5.7l-9.9,9.9,20.6,20.6H6.45v14h78.9L64.75,70.8l9.9,9.9,36.8-36.8A1,1,0,0,0,111.45,42.5Z"></path> </svg></div>').insertBefore(".tina_slider_sail_away .et_pb_slider");var t=3;e(window).width()<=980&&(t=2),e(window).width()<=480&&(t=1),e(".tina_slider_sail_away .et_pb_slider .et_pb_slide").each(function(){var t=e(this).css("background-image");e(this).find(".et_pb_slider_container_inner").css("background-image",t),e(this).css("background-image","none")});var i=e(".tina_slider_sail_away .et_pb_slider").width(),s=e(".tina_slider_sail_away .et_pb_slider .et_pb_slide").length,l=i/t,a=s*l;console.log(i),e(".tina_slider_sail_away .et_pb_slider .et_pb_slide").outerWidth(l),e(".tina_slider_sail_away .et_pb_slider .et_pb_slides").width(a+30),e(".tina_slider_sail_away .et_pb_slider .et_pb_slides .et_pb_slide:first-child").addClass("active_slide"),e(".tina_slider_sail_away .et-pb-slider-arrows a.et-pb-arrow-next").on("click",function(i){i.preventDefault();var s=e(this);setTimeout(function(){s.closest(".et_pb_slider").find(".et_pb_slide.active_slide").nextAll().length>=t?s.closest(".et_pb_slider").find(".et_pb_slide.active_slide").removeClass("active_slide").next().addClass("active_slide"):(s.closest(".et_pb_slider").find(".et_pb_slide.active_slide").removeClass("active_slide"),s.closest(".et_pb_slider").find(".et_pb_slide:first-child").addClass("active_slide"))},50)}),e(".tina_slider_sail_away .et-pb-slider-arrows a.et-pb-arrow-prev").on("click",function(i){i.preventDefault();var s=e(this);setTimeout(function(){0!==s.closest(".et_pb_slider").find(".et_pb_slide.active_slide").prevAll().length?s.closest(".et_pb_slider").find(".et_pb_slide.active_slide").removeClass("active_slide").prev().addClass("active_slide"):(s.closest(".et_pb_slider").find(".et_pb_slide.active_slide").removeClass("active_slide"),s.closest(".et_pb_slider").find(".et_pb_slide:nth-last-child("+t+")").addClass("active_slide"))},50)}),e(".tina_slider_sail_away .et-pb-slider-arrows a").on("click",function(t){t.preventDefault();var i=e(this).closest(".et_pb_slider"),s=e(this);setTimeout(function(){i.find(".et_pb_slide.active_slide").prevAll().length;var e=s.closest(".et_pb_slider").find(".et_pb_slide.active_slide").prevAll().length;s.closest(".et_pb_slider").find(".et_pb_slides").css("transform","translate(-"+e*l+"px, 0)")},50)}),this.cursorOutLeftRightSide=null,e(".tina_slider_sail_away .et_pb_slider").hover(function(){let t;this.cursorOutLeftRightSide=e(this).width()-(event.pageX-e(this).offset().left)>e(this).width()/2?"left":"right",t=e(this).height()-(event.pageY-e(this).offset().top)>e(this).height()/2?-135:"right"===this.cursorOutLeftRightSide?135:-315,TweenMax.set(e(this).closest(".et_pb_column").find(".arrow-cursor svg"),{rotation:t}),this.cursorOutTopBottomSide=null,this.cursorOutTopBottomSide=e(this).height()-(event.pageY-e(this).offset().top)>e(this).width()/2?"top":"bottom",TweenMax.to(e(this).closest(".et_pb_column").find(".arrow-cursor svg"),.3,{rotation:"left"===this.cursorOutLeftRightSide?-180:0,scale:1,opacity:1,ease:Back.easeOut.config(1.7)})},function(){let t=0;t=e(this).height()-(event.pageY-e(this).offset().top)>e(this).height()/2?"right"===this.cursorSide?-135:-45:"right"===this.cursorSide?135:-315,TweenMax.to(e(this).closest(".et_pb_column").find(".arrow-cursor svg"),.3,{rotation:t,opacity:0,scale:.3})}),e(".tina_slider_sail_away .et_pb_slider").mousemove(function(t){this.cursorSide=null,this.cursorSide=e(this).width()-(t.pageX-e(this).offset().left)>e(this).width()/2?"left":"right",TweenMax.to(e(this).closest(".et_pb_column").find(".arrow-cursor svg"),.3,{rotation:"left"===this.cursorSide?-180:0,ease:Back.easeOut.config(1.7)}),e(this).closest(".et_pb_column").find(".arrow-cursor").css("transform","translate("+(t.pageX-e(this).offset().left)+"px, "+(t.pageY-e(this).offset().top)+"px)")})}},t)}(jQuery);