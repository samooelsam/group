! function(t) {
    var a = 1e3;
    ua = navigator.userAgent, (ua.indexOf("MSIE ") > -1 || ua.indexOf("Trident/") > -1) && (a = 1e4), t("body").hasClass("et-fb") && (a = 1e4), setTimeout(function() {
        if (0 !== t(".ragnar_tabs_the_track").length) {
            var a = t(window).width(),
                e = t(".ragnar_tabs_the_track .et_pb_row.image_row").prev(".et_pb_row").outerWidth(),
                r = t(".ragnar_tabs_the_track .et_pb_row.image_row").prev(".et_pb_row").width();

            function _() {
                var a = t(window).height(),
                    e = t(window).scrollTop();
                t(".ragnar_tabs_the_track .et_pb_row:not(.sticky_text )").each(function() {
                    var r = t(this).attr("id"),
                        _ = t(this).offset().top;
                    r && parseInt(_) <= parseInt(e) + parseInt(a) / 2 && t(".ragnar_tabs_the_track .sticky_text .et_pb_text ul li").each(function() {
                        var a = t(this).find("a").attr("href").replace(/\#/g, "");
                        r === a && "active" != t(this).attr("active-item") && (t(".ragnar_tabs_the_track .sticky_text .et_pb_text ul li").attr("active-item", ""), t(this).attr("active-item", "active"))
                    })
                }), t(".ragnar_tabs_the_track .sticky_text .et_pb_text ul li").removeClass("active_item"), t('.ragnar_tabs_the_track .sticky_text .et_pb_text ul li[active-item="active"]').addClass("active_item")
            }
            t(".ragnar_tabs_the_track .et_pb_row.image_row .et_pb_image ").width((a - e) / 2 + r), _(), t(window).scroll(function() {
                _(), t(".ragnar_tabs_the_track .et_pb_row.dark_bg, .ragnar_tabs_the_track .et_pb_row.dark_bg_second, .ragnar_tabs_the_track .et_pb_row.dark_bg_third").each(function() {
                    var a = t(this).offset().top,
                        e = t(this).offset().top + t(this).outerHeight();
                    a <= t(window).height() + t(window).scrollTop() && a + t(this).outerHeight() >= t(window).scrollTop() && t(".ragnar_tabs_the_track .sticky_text .et_pb_text ul li").each(function() {
                        t(this).offset().top >= a && t(this).offset().top <= e ? t(this).attr("color", "dark") : t(this).attr("color", "light")
                    })
                })
            });
            var i = t(".ragnar_tabs_the_track").offset(),
                s = t(".ragnar_tabs_the_track .et_pb_row.sticky_text"),
                o = s.find(".et_pb_text"),
                n = s.find(".et_pb_text").clone().attr("class", "tmp").css("visibility", "hidden");
            window.addEventListener("scroll", function() {
                if (t(window).scrollTop() > i.top && t(".ragnar_tabs_the_track .et_pb_row:nth-last-child(2)").offset().top >= t(window).scrollTop()) s.append(n), o.css({
                    position: "fixed",
                    top: 0,
                    transform: "translate(0, 0px)"
                });
                else if (t(".ragnar_tabs_the_track .et_pb_row:nth-last-child(2)").offset().top < t(window).scrollTop()) {
                    var a = t(".ragnar_tabs_the_track .et_pb_row:nth-last-child(2)").outerHeight() + t(".ragnar_tabs_the_track .et_pb_row:last-child").outerHeight();
                    s.append(n), o.css({
                        position: "static",
                        top: "",
                        transform: "translate(0, " + (t(".ragnar_tabs_the_track").outerHeight() - a) + "px)"
                    })
                } else s.find(".tmp").remove(), o.css({
                    position: "static",
                    top: "",
                    transform: "translate(0, 0px)"
                })
            })
        }
    }, a)
}(jQuery);