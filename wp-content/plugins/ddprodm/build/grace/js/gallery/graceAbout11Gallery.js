!(function (e) {
    var t = 0;
    ((ua = navigator.userAgent).indexOf("MSIE ") > -1 ||
        ua.indexOf("Trident/") > -1) &&
        (t = 5e3),
        e("body").hasClass("et-fb") && (t = 1e4),
        setTimeout(function () {
            0 !== e(".grace_about11_gallery").length &&
                e(".grace_about11_gallery").each(function () {
                    e('<div class="circle_box"></div>').appendTo(
                        e(this).find(
                            ".et_pb_grid_item .et_pb_gallery_image .et_overlay"
                        )
                    );
                    for (var t = 1; t <= 8; t++) {
                        e('<span class="pattern_box"></span>').appendTo(
                            e(this).find(
                                ".et_pb_grid_item .et_pb_gallery_image .et_overlay .circle_box"
                            )
                        );
                        var a = 11.25 * t;
                        e(this)
                            .find(
                                ".et_pb_grid_item .et_pb_gallery_image .et_overlay  .pattern_box:nth-child(" +
                                    t +
                                    ")"
                            )
                            .css(
                                "cssText",
                                "transform: translate(-50%, -50%) rotate(" +
                                    a +
                                    "deg)"
                            );
                    }
                });
        }, t);
})(jQuery);
