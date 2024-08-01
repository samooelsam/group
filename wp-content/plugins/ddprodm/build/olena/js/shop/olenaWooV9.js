(function ($) {
    function isIE() {
        ua = navigator.userAgent;
        var is_ie = ua.indexOf("MSIE ") > -1 || ua.indexOf("Trident/") > -1;

        return is_ie;
    }

    var olenaWooV9 = 0;

    if (isIE()) {
        olenaWooV9 = 5000;
    }

    if ($('body').hasClass('et-fb')) {
        olenaWooV9 = 10000;
    }

    setTimeout(function () {
        if($('.olena_woo_v9').length !== 0){

            var pageUrl = window.location.href
            $('#page-container .olena_woo_v9 .et_pb_shop li.product').each(function () {
                var check = "post-";
                var productId;

                var cls = $(this).attr('class').split(' ');
                for (var i = 0; i < cls.length; i++) {
                    if (cls[i].indexOf(check) > -1) {
                        productId = cls[i].slice(check.length, cls[i].length);
                        break;
                    }
                }


                var imageSrc = $(this).find('.et_shop_image img').attr('src');
                var imageSrcset = $(this).find('.et_shop_image img').attr('srcset');
                imageSrc = imageSrc.replace(/-([0-9][0-9][0-9]x[0-9][0-9])\w+/g, '');
                imageSrcset = imageSrc.replace(/-([0-9][0-9][0-9]x[0-9][0-9])\w+/g, '');
                $(this).find('.et_shop_image img').attr('src', imageSrc);
                $(this).find('.et_shop_image img').attr('srcset', imageSrcset);

                $('<a class="add_to_cart" href="'+ pageUrl +'/?add-to-cart='+ productId +'"></a>').appendTo($(this).find('.et_shop_image'))

                $(this).find('.et_shop_image .et_overlay ').appendTo($(this).find('.add_to_cart'))
            })



        }

    }, olenaWooV9);

    //  END FREDDIE CONTENT *******************************************************
})(jQuery);