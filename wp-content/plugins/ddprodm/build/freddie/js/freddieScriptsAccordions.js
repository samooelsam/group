!function(e){var i=0;ua=navigator.userAgent,(ua.indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(i=5e3),e("body").hasClass("et-fb")&&(i=1e4),setTimeout(function(){0!==e(".freddie_blurred_vision_accordion").length&&(e(".freddie_blurred_vision_accordion .et_pb_accordion").each(function(){e(this).prepend('<div class="toggle_icon"></div>')}),e(".freddie_blurred_vision_accordion .et_pb_toggle").on("click",function(){e(".toggle_icon").css("top",e(this).position().top);var i=e(this).prevAll(".et_pb_toggle").length+1;e(".freddie_blurred_vision_accordion .et_pb_video_slider .et_pb_slider .et_pb_slide").each(function(){if(0!==e(this).find(".et_pb_video_box video").length){var i=e(this).find(".et_pb_video_box").html();e(this).find(".et_pb_video_box").html(""),e(this).find(".et_pb_video_box").html(i)}if(0!==e(this).find("iframe").length){e(this).find("iframe").attr("src",e(this).find("iframe").attr("src").replace("autoplay=1","autoplay=0"));var d=e(this).find(".fluid-width-video-wrapper").html();e(this).find(".fluid-width-video-wrapper").html(""),e(this).find(".fluid-width-video-wrapper").html(d)}}),e(".freddie_blurred_vision_accordion .et_pb_video_slider .et_pb_slider .et_pb_slide").removeClass("et-pb-active-slide"),e(".freddie_blurred_vision_accordion .et_pb_video_slider .et_pb_slider .et_pb_slide:nth-child("+i+")").addClass("et-pb-active-slide"),e(".freddie_blurred_vision_accordion .et_pb_video_slider .et_pb_slider .et_pb_slide").hide("slow"),e(".freddie_blurred_vision_accordion .et_pb_video_slider .et_pb_slider .et_pb_slide:nth-child("+i+")").show("slow")}),e(".freddie_blurred_vision_accordion .et_pb_video_slider .et_pb_slider .et_pb_slide").each(function(){e(this).removeClass("et-pb-active-slide")}))},i)}(jQuery);