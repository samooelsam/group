!function(e){e(".et_pb_column .et_pb_social_media_follow").each(function(){e(this).find("li").each(function(){var i=e(this).find("a").attr("title").replace("Follow on","");e(this).find("a .et_pb_social_media_follow_network_name").text(i)})}),followDelay=1e3,e("body").hasClass("et-fb")&&(followDelay=5e3),setTimeout(function(){e("body.et-fb .et_pb_column .et_pb_social_media_follow").each(function(){e(this).find("li").each(function(){var i=e(this).find("a").attr("title").replace("Follow on","");e(this).find("a .et_pb_social_media_follow_network_name").text(i)})})},followDelay),setTimeout(function(){var i="";i=e(".impi_sliders_1 .et_pb_slide:nth-child(2)").css("background-image"),e('<div class="slider_next_post_img"></div>').appendTo(e(".impi_sliders_1 .et-pb-slider-arrows")),e(".impi_sliders_1 .et-pb-slider-arrows .slider_next_post_img").css("background-image",i),e(".impi_sliders_1 .et_pb_slider .et-pb-slider-arrows a").on("click",function(t){setTimeout(function(){e(".impi_sliders_1 .et_pb_slide.et-pb-active-slide").nextAll().length<=0&&(i=e(".impi_sliders_1 .et_pb_slide:first-child").css("background-image")),e(".impi_sliders_1 .et_pb_slide.et-pb-active-slide").nextAll().length>0&&(i=e(".impi_sliders_1 .et_pb_slide.et-pb-active-slide").next().css("background-image")),e(".impi_sliders_1 .et-pb-slider-arrows .slider_next_post_img").css("background-image",i)},100)})},1e3),setInterval(function(){e(".impi_sliders_1 .et_slider_auto .et_pb_slide.et-pb-active-slide").nextAll().length<=0&&(nextBgImageSlide1=e(".impi_sliders_1 .et_slider_auto .et_pb_slide:first-child").css("background-image")),e(".impi_sliders_1 .et_slider_auto .et_pb_slide.et-pb-active-slide").nextAll().length>0&&(nextBgImageSlide1=e(".impi_sliders_1 .et_slider_auto .et_pb_slide.et-pb-active-slide").next().css("background-image")),e(".impi_sliders_1 .et_slider_auto .et-pb-slider-arrows .slider_next_post_img").css("background-image",nextBgImageSlide1)},100),setTimeout(function(){e(".impi_sliders_2 .et-pb-slider-arrows").insertBefore(e(".impi_sliders_2 .et_pb_slides"))},1e3),setTimeout(function(){e(".impi_sliders_3").each(function(){e(this).find(".et-pb-slider-arrows").insertBefore(e(this).find(".et_pb_slides"))})},1e3);var i=1e3,t=0;if(e("body").hasClass("et-fb")){t=7e3;i=0}setTimeout(function(){e(".impi_sliders_3").length>0&&setTimeout(function(){e(".impi_sliders_3").each(function(){var i=3;e(window).width()>="981"&&(e(this).find(".et_pb_slider .et_pb_slide:first-child").clone().removeClass("et-pb-active-slide").insertAfter(e(this).find(".et_pb_slider .et_pb_slide:last-child")),e(this).find(".et_pb_slider .et_pb_slide:nth-child(2)").clone().insertAfter(e(this).find(".et_pb_slider .et_pb_slide:last-child")),e(this).find(".et_pb_slider .et_pb_slide:nth-child(3)").clone().insertAfter(e(this).find(".et_pb_slider .et_pb_slide:last-child"))),e(window).width()>="2000"&&(e(this).find(".et_pb_slider .et_pb_slide:nth-child(4)").clone().insertAfter(e(this).find(".et_pb_slider .et_pb_slide:last-child")),i=4),e(window).width()<="980"&&e(window).width()>="768"&&(e(this).find(".et_pb_slider .et_pb_slide:nth-child(2)").clone().insertAfter(e(this).find(".et_pb_slider .et_pb_slide:last-child")),e(this).find(".et_pb_slider .et_pb_slide:nth-child(2)").clone().insertBefore(e(this).find(".et_pb_slider .et_pb_slide:first-child")),i=2),e(window).width()<="767"&&(i=1);var t=e(this).find(".et_pb_slide").length,_=e(this).width()/i;e(this).find(".et_pb_slide").css("cssText","width: "+Math.floor(_-30)+"px !important;");var l=e(this).find(".et_pb_slide").outerWidth()+30,s=t*l,d=l-94;e(window).width()<="767"&&(d=0),e(this).find(".et_pb_slides").css({width:s+"px","margin-left":"-"+d+"px"}),e(this).css("opacity",1)})},i),setTimeout(function(){e(".impi_sliders_3 .et-pb-slider-arrows a").on("click",function(i){i.preventDefault();var t=e(this);setTimeout(function(){e(window).width();var i=t.closest(".et_pb_slider").find(".et_pb_slide").outerWidth()+30,_=t.closest(".et_pb_slider").find(".et_pb_slide.et-pb-active-slide").prevAll().length*i;t.closest(".et_pb_slider").find(".et_pb_slides").css("transform","translate(-"+_+"px, 0)")},100)}),e(".impi_sliders_3 .et_pb_slider").hasClass("et_slider_auto")&&setInterval(function(){var i=0;e(window).width()<="767"&&(i=0);var t=e(".impi_sliders_3 .et_pb_slide").outerWidth()+30,_=(e(".impi_sliders_3 .et_pb_slide.et-pb-active-slide").prevAll().length-i)*t;e(".impi_sliders_3 .et_pb_slides").css("transform","translate(-"+_+"px, 0)")},100)},i)},t),setTimeout(function(){var i="";i=e(".impi_next_here_header .et_pb_slide:nth-child(2)").css("background-image");var t=e(".impi_next_here_header .et_pb_slide:nth-child(2) h2.et_pb_slide_title").text();e('<div class="next_slide_info"><div class="slider_next_post_img"></div><h2 class="next_title">'+t+"<h2></div>").insertBefore(e(".impi_next_here_header .et_pb_slides")),e(".impi_next_here_header .slider_next_post_img").css("background-image",i);var _=e(".impi_next_here_header .et_pb_slide").length;e('<div class="slider_number"><span class="numers_line"><span class="numers_line_inner"></span></span><</div>').insertAfter(e(".impi_next_here_header .et_pb_slider"));var l=e(".impi_next_here_header .slider_number .numers_line").width()/_;e(".impi_next_here_header .slider_number .numers_line .numers_line_inner").width(l),e(".impi_next_here_header .et_pb_slider .et-pb-slider-arrows a").on("click",function(_){setTimeout(function(){e(".impi_next_here_header .et_pb_slide.et-pb-active-slide").nextAll().length<=0&&(i=e(".impi_next_here_header .et_pb_slide:first-child").css("background-image"),t=e(".impi_next_here_header .et_pb_slide:first-child h2.et_pb_slide_title").text()),e(".impi_next_here_header .et_pb_slide.et-pb-active-slide").nextAll().length>0&&(i=e(".impi_next_here_header .et_pb_slide.et-pb-active-slide").next().css("background-image"),t=e(".impi_next_here_header .et_pb_slide.et-pb-active-slide").next().find("h2.et_pb_slide_title").text()),e(".impi_next_here_header .slider_next_post_img").css("background-image",i),e(".impi_next_here_header .next_title").text(t),setTimeout(function(){var i=e(".impi_next_here_header .et_pb_slide.et-pb-active-slide").prevAll().length,t=e(".impi_next_here_header .et_pb_slide.et-pb-active-slide").prevAll().length+showHomeSlideritems;e(".impi_next_here_header .slider_number .slider_active_number").text("0"+t),e(".impi_next_here_header .slider_number .numers_line .numers_line_inner").css("transform","translate("+l*i+"px,0)")},200)},100)})},1500),setInterval(function(){var i=e(".impi_next_here_header .et_pb_slide").length,t=e(".impi_next_here_header .slider_number .numers_line").width()/i,_=e(".impi_next_here_header .et_pb_slide.et-pb-active-slide").prevAll().length;e(".impi_next_here_header .et_pb_slide.et-pb-active-slide").prevAll().length;e(".impi_next_here_header .slider_number .numers_line .numers_line_inner").css("transform","translate("+t*_+"px,0)")},50),setTimeout(function(){if(0!==e(".impi_ally_header").length){var i=e(".impi_ally_header .et_pb_slider .et-pb-active-slide").prevAll().length,t=i+2,_=i+3,l=e(".impi_ally_header .et_pb_slider .et-pb-active-slide").next().find("h2.et_pb_slide_title").text(),s=e(".impi_ally_header .et_pb_slider .et-pb-active-slide").next().next().find("h2.et_pb_slide_title").text();e('<div class="next_post_title_container"><div class="next_post"><span class="sldie_count">0'+t+'</span><h2 class="next_post_title">'+l+'</h2></div><div class="next2_post"><span class="sldie_count2">0'+_+'</span><h2 class="next2_post_title">'+s+"</h2></div></div>").insertAfter(e(".impi_ally_header .et_pb_slides ")),e(".impi_ally_header .et_pb_slider .et-pb-slider-arrows a, .impi_ally_header .et_pb_slider .et-pb-controllers a").on("click",function(){setTimeout(function(){if(e(".impi_ally_header .et_pb_slider .et-pb-active-slide").nextAll().length>1){var t=(d=e(".impi_ally_header .et_pb_slider .et-pb-active-slide").prevAll().length)+2,_=d+3;e(".impi_ally_header .sldie_count").text("0"+t),e(".impi_ally_header .sldie_count2").text("0"+_);var l=e(".impi_ally_header .et_pb_slider .et-pb-active-slide").next().find("h2.et_pb_slide_title").text();e(".impi_ally_header .next_post_title").text(l);var s=e(".impi_ally_header .et_pb_slider .et-pb-active-slide").next().next().find("h2.et_pb_slide_title").text();e(".impi_ally_header .next2_post_title").text(s)}else if(1===e(".impi_ally_header .et_pb_slider .et-pb-active-slide").nextAll().length){t=(d=e(".impi_ally_header .et_pb_slider .et-pb-active-slide").prevAll().length)+2,_=1;e(".impi_ally_header .sldie_count").text("0"+t),e(".impi_ally_header .sldie_count2").text("0"+_);l=e(".impi_ally_header .et_pb_slider .et-pb-active-slide").next().find("h2.et_pb_slide_title").text();e(".impi_ally_header .next_post_title").text(l);s=e(".impi_ally_header .et_pb_slider .et_pb_slide:first-child").find("h2.et_pb_slide_title").text();e(".impi_ally_header .next2_post_title").text(s)}else if(0===e(".impi_ally_header .et_pb_slider .et-pb-active-slide").nextAll().length){t=1,_=2;e(".impi_ally_header .sldie_count").text("0"+t),e(".impi_ally_header .sldie_count2").text("0"+_);var d=e(".impi_ally_header .et_pb_slider .et-pb-active-slide").prevAll().length;t=i+1,_=i+2;e(".impi_ally_header .sldie_count").text("0"+t),e(".impi_ally_header .sldie_count2").text("0"+_);l=e(".impi_ally_header .et_pb_slider .et_pb_slide:first-child").find("h2.et_pb_slide_title").text();e(".impi_ally_header .next_post_title").text(l);s=e(".impi_ally_header .et_pb_slider .et_pb_slide:nth-child(2)").find("h2.et_pb_slide_title").text();e(".impi_ally_header .next2_post_title").text(s)}},0)})}},1e3);var _=1500;ua=navigator.userAgent,(ua.indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(_=5e3),setTimeout(function(){e(".impi_endorser_header .et_pb_slider .et-pb-controllers a").each(function(){var i=e(this).text();e(this).html('<span class="slide_number">0'+i+'</span><div class="slide_title"></div>')});var i="1";e(".impi_endorser_header .et_pb_slide").each(function(){var t=e(this).find(".et_pb_slide_description .et_pb_slide_title").text();e(".impi_endorser_header .et-pb-controllers a:nth-child("+i+") .slide_title").text(t),i++}),e(".impi_endorser_header .et_pb_slider .et-pb-controllers a.et-pb-active-control .slide_title").show("slow"),e(".impi_endorser_header .et_pb_slider .et-pb-controllers a").on("click",function(){e(".impi_endorser_header .et_pb_slider .et-pb-controllers a .slide_title").slideUp("slow"),e(this).find(".slide_title").slideDown("slow")}),e(".impi_endorser_header .et-pb-slider-arrows a").on("click",function(){setTimeout(function(){e(".impi_endorser_header .et_pb_slider .et-pb-controllers a .slide_title").hide("slow"),e(".impi_endorser_header .et_pb_slider .et-pb-controllers a.et-pb-active-control .slide_title").show("slow")},200)})},_),setTimeout(function(){e(".impi_top_dog_header .et_pb_slider .et_pb_slide").each(function(){var i=e(this).css("background-image");e(this).find(".et_pb_button_wrapper .et_pb_button").css("background-image",i),e(this).css("background-image","none")})},_),setTimeout(function(){var i=e(".impi_heroine_product_slider .et_pb_slide:nth-child(2) .et_pb_slide_image img").attr("src");e('<div class="slider_next_post_img"></div>').insertAfter(e(".impi_heroine_product_slider .et_pb_slides")),e(".impi_heroine_product_slider .slider_next_post_img").css("background-image","url("+i+")"),e(".impi_heroine_product_slider .et-pb-controllers a, .impi_heroine_product_slider .et-pb-slider-arrows a").on("click",function(t){t.preventDefault(),setTimeout(function(){e(".impi_heroine_product_slider .et_pb_slide.et-pb-active-slide").nextAll().length<=0&&(i=e(".impi_heroine_product_slider .et_pb_slide:first-child .et_pb_slide_image img").attr("src")),e(".impi_heroine_product_slider .et_pb_slide.et-pb-active-slide").nextAll().length>0&&(i=e(".impi_heroine_product_slider .et_pb_slide.et-pb-active-slide").next().find(" .et_pb_slide_image img").attr("src")),e(".impi_heroine_product_slider .slider_next_post_img").css("background-image","url("+i+")")},100)})},_)}(jQuery);