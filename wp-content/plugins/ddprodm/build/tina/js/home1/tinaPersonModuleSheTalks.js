!function(e){var s=1500;ua=navigator.userAgent,(ua.indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(s=5e3),e("body").hasClass("et-fb")&&(s=1e4),setTimeout(function(){0!==e(".tina_she_talks_person_module").length&&(e(".tina_she_talks_person_module .et_pb_slider.small_slider .et_pb_slide").each(function(){var s=e(this).find("h2.et_pb_slide_title").text(),l=e(this).prevAll(".et_pb_slide").length+1;e(this).closest(".et_pb_slider.small_slider").find(e(".et-pb-controllers a:nth-child("+l+")")).html('<span class="title">'+s+"</span>")}),e(".tina_she_talks_person_module .et_pb_slider.big_slider .et_pb_slide:first-child").addClass("active_slide"),e(".tina_she_talks_person_module .et_pb_slider.small_slider .et-pb-slider-arrows a, .tina_she_talks_person_module .et_pb_slider.small_slider .et-pb-controllers a").on("click",function(){var s=e(this);setTimeout(function(){var l=s.closest(".et_pb_slider").find(".et-pb-active-slide").prevAll(".et_pb_slide").length+1;e(".tina_she_talks_person_module .et_pb_slider.big_slider .et_pb_slide").removeClass("active_slide"),e(".tina_she_talks_person_module .et_pb_slider.big_slider .et_pb_slide:nth-child("+l+")").addClass("active_slide")},50)}),e(".tina_she_talks_person_module .et_pb_slider.small_slider").hasClass("et_slider_auto")&&setInterval(function(){var s=e(".tina_she_talks_person_module .et_pb_slider.small_slider .et-pb-active-slide").prevAll(".et_pb_slide").length+1;e(".tina_she_talks_person_module .et_pb_slider.big_slider .et_pb_slide").removeClass("active_slide"),e(".tina_she_talks_person_module .et_pb_slider.big_slider .et_pb_slide:nth-child("+s+")").addClass("active_slide")},50))},s)}(jQuery);