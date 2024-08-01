


(function ($) {

    function isIE() {
        ua = navigator.userAgent;
        var is_ie = ua.indexOf("MSIE ") > -1 || ua.indexOf("Trident/") > -1;

        return is_ie;
    }

    var graceContentDrive  = 500;

    if (isIE()) {
        graceContentDrive = 5000;
    }

    if ($('body').hasClass('et-fb')) {
        graceContentDrive = 10000;
    }

    setTimeout(function () {
        if ($('.grace_content_drive ').length !== 0) {
            console.log(graceContentDrive)

            $("body:not(.et-fb) .grace_content_drive .video-popup-2 .et_pb_video").on('click', function (e) {
                e.preventDefault();
                var hrefLink = $(this).find('source').attr('src');

                $.fancybox({
                    'padding': 0,
                    'autoScale': false,
                    'transitionIn': 'none',
                    'transitionOut': 'none',
                    'title': this.title,
                    'width': 680,
                    'height': 495,
                    'href': hrefLink,
                    'type': 'swf',
                    'swf': {
                        'wmode': 'transparent',
                        'allowfullscreen': 'true'
                    }
                });

                return false;

            });
            //
            $(".grace_content_drive .video-popup-2 .et_pb_video_play").on('click', function (e) {
                e.preventDefault();
            });
            //
            $(".grace_content_drive .video-popup-2 .et_pb_video_overlay").css('pointer-events', 'none');
            $(".grace_content_drive .video-popup-2 .et_pb_video_overlay").on('click', function (e) {
                e.preventDefault();
            });

        }

    }, graceContentDrive);

})(jQuery);