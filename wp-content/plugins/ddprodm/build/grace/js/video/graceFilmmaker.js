!(function (e) {
    var t = 0;
    ((ua = navigator.userAgent).indexOf("MSIE ") > -1 ||
        ua.indexOf("Trident/") > -1) &&
        (t = 5e3),
        e("body").hasClass("et-fb") && (t = 1e4),
        setTimeout(function () {
            0 !== e(".grace_content_filmmaker").length &&
                e(".grace_content_filmmaker").each(function () {
                    for (var t = 1; t <= 8; t++) {
                        e('<span class="pattern_box"></span>').appendTo(
                            e(this).find(".et_pb_video a.et_pb_video_play")
                        );
                        var n = 11.25 * t;
                        e(this)
                            .find(
                                ".et_pb_video a.et_pb_video_play .pattern_box:nth-child(" +
                                    t +
                                    ")"
                            )
                            .css(
                                "cssText",
                                "transform: translate(-50%, -50%) rotate(" +
                                    n +
                                    "deg)"
                            );
                    }
                });
        }, t);
})(jQuery);
