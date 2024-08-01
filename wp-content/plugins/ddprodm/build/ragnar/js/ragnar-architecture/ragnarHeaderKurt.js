(function ($) {
    function isIE() {
        ua = navigator.userAgent;
        var is_ie = ua.indexOf("MSIE ") > -1 || ua.indexOf("Trident/") > -1;

        return is_ie;
    }

    var ragnarHeaderKurt  = 1000;

    if (isIE()) {
        ragnarHeaderKurt = 10000;
    }

    if ($('body').hasClass('et-fb')) {
        ragnarHeaderKurt = 10000;
    }

    setTimeout(function () {
        if($('.ragnar_header_kurt ').length !== 0){
            var shapeCount = 1;
            $('.ragnar_header_kurt .et_pb_blurb').each(function () {
                $(this).prepend($('<div class="kurt-content-shapes-'+ shapeCount +'"><div class="kurt-content-shapes-'+ shapeCount +'-shape-1"></div><div class="kurt-content-shapes-'+ shapeCount +'-shape-2"></div></div>'));

                if(shapeCount === 1){
                    $('<div class="kurt-1-inner-shape"></div>').appendTo($(this).find('.kurt-content-shapes-1-shape-1'))
                    $('<div class="kurt-1-inner-shape"></div>').appendTo($(this).find('.kurt-content-shapes-1-shape-2'))
                }

                shapeCount = shapeCount + 1;
            })
        }

    }, ragnarHeaderKurt);

})(jQuery);