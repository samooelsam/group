! function(e) {
    var i = 1e3;
    ua = navigator.userAgent, (ua.indexOf("MSIE ") > -1 || ua.indexOf("Trident/") > -1) && (i = 5e3), e("body").hasClass("et-fb") && (i = 1e4), setTimeout(function() {
        0 !== e(".grace_merga_slider").length && (e(".grace_merga_slider ").each(function() {
            e(this);
            e('<div class="slide_prev_image"></div>').insertBefore(e(this).find(".et_pb_slider")), e('<div class="slide_next_image"></div>').insertAfter(e(this).find(".et_pb_slider"));
            e(this).find(".et_pb_slide ").each(function() {
                var i = e(this).find(".et_pb_slide_image img").attr("src");
                e('<img class="next_image" src="' + i + '">').appendTo(e(this).closest(".et_pb_slider").next(".slide_next_image")), e('<img class="next_image" src="' + i + '">').appendTo(e(this).closest(".et_pb_slider").prev(".slide_prev_image"))
            });
            e(this).find(".et_pb_slide.et-pb-active-slide").prevAll().length;
            e(this).find(".slide_next_image img:nth-child(2)").addClass("active"), e(this).find(".slide_prev_image img:last-child").addClass("active");
            var i = 0;
            e(this).find(".et_pb_slide .et_pb_slide_image").each(function() {
                e(this).height() > i && (i = e(this).height())
            }), e(this).find(".et-pb-slider-arrows").css("top", i + "px")
        }), setInterval(function() {
            e(".grace_merga_slider").each(function() {
                var i = e(this).find(".et_pb_slider");
                i.find(".et_pb_slide.et-pb-active-slide").prevAll().length;
                if (0 !== i.find(".et-pb-active-slide").nextAll().length) var s = i.find(".et_pb_slide.et-pb-active-slide").prevAll().length;
                else s = -1;
                if (i.next(".slide_next_image").find("img").removeClass("active"), i.prev(".slide_prev_image").find("img").removeClass("active"), 0 !== i.find(".et-pb-active-slide").prevAll().length) {
                    var t = i.find(".et_pb_slide.et-pb-active-slide").prevAll().length;
                    i.prev(".slide_prev_image").find(" img:nth-child(" + t + ")").addClass("active")
                } else i.prev(".slide_prev_image").find(" img:last-child").addClass("active");
                i.next(".slide_next_image").find(" img:nth-child(" + (s + 2) + ")").addClass("active"), i.hasClass("et_slide_transition_to_previous") ? i.closest(".et_pb_column").addClass("prev_el") : i.closest(".et_pb_column").removeClass("prev_el")
            })
        }, 50))
    }, i)
}(jQuery);