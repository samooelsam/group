(function ($) {


    function isIE() {
        ua = navigator.userAgent;
        var is_ie = ua.indexOf("MSIE ") > -1 || ua.indexOf("Trident/") > -1;

        return is_ie;
    }

    var gracePersonCarina = 1000;

    if (isIE()) {
        gracePersonCarina = 5000;
    }

    if ($('body').hasClass('et-fb')) {
        gracePersonCarina = 10000;
    }

    setTimeout(function () {

        if($('.grace_person_california').length !== 0){

            $('.grace_person_california .et_pb_team_member').each(function (){
                $(this).find('.et_pb_member_social_links').insertAfter($(this).find('.et_pb_team_member_image img'))
            })

        }

    }, gracePersonCarina);

})(jQuery);