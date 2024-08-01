(function ($) {

    function isIE() {
        ua = navigator.userAgent;
        var is_ie = ua.indexOf("MSIE ") > -1 || ua.indexOf("Trident/") > -1;

        return is_ie;
    }

    var graceAboutPage11 = 0;

    if (isIE()) {
        graceAboutPage11 = 5000;
    }

    if ($('body').hasClass('et-fb')) {
        graceAboutPage11 = 10000;
    }

    setTimeout(function () {
        if ($('.grace_about11_logos').length !== 0) {
            $('.grace_about11_logos').each(function () {
                $('<div class="circle_box"></div>').appendTo($(this).find('.et_pb_number_counter'));
                for(var i=1; i <= 8; i++){
                    $('<span class="pattern_box"></span>').appendTo($(this).find('.et_pb_number_counter .circle_box'));
                    var rotateSize = i*11.25;
                    $(this).find('.et_pb_number_counter  .pattern_box:nth-child(' + i + ')').css('cssText', 'transform: translate(-50%, -50%) rotate('+ rotateSize +'deg)')
                }

            })
        }

        if ($('.grace_about11_gallery').length !== 0) {
            $('.grace_about11_gallery').each(function () {
                $('<div class="circle_box"></div>').appendTo($(this).find('.et_pb_grid_item .et_pb_gallery_image .et_overlay'));
                for(var i=1; i <= 8; i++){
                    $('<span class="pattern_box"></span>').appendTo($(this).find('.et_pb_grid_item .et_pb_gallery_image .et_overlay .circle_box'));
                    var rotateSize = i*11.25;
                    $(this).find('.et_pb_grid_item .et_pb_gallery_image .et_overlay  .pattern_box:nth-child(' + i + ')').css('cssText', 'transform: translate(-50%, -50%) rotate('+ rotateSize +'deg)')
                }

            })
        }

    }, graceAboutPage11);

})(jQuery);