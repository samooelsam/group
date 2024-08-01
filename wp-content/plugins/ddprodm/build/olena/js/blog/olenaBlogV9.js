(function ($) {

    function isIE() {
        ua = navigator.userAgent;
        var is_ie = ua.indexOf("MSIE ") > -1 || ua.indexOf("Trident/") > -1;

        return is_ie;
    }

    var olenaBlogV9 = 0;

    if (isIE()) {
        olenaBlogV9 = 5000;
    }

    if ($('body').hasClass('et-fb')) {
        olenaBlogV9 = 10000;
    }

    setTimeout(function () {

        if ($('.olena_blog_v9').length !== 0) {
            $('.olena_blog_v9 article.et_pb_post').each(function () {
                var imageSrc = $(this).find('img').attr('src');
                var imageSrcset = $(this).find('img').attr('srcset');

                imageSrc = imageSrc.replace(/-([0-9][0-9][0-9]x[0-9][0-9])\w+/g, '');


                $(this).find('img').attr('src', imageSrc);


                if(imageSrcset){
                    imageSrcset = imageSrcset.replace(/-([0-9][0-9][0-9]x[0-9][0-9])\w+/g, '');
                    $(this).find('img').attr('srcset', imageSrcset);
                }


            });

            setInterval(function () {
                if (!$('.olena_blog_v9 .et_pb_posts article').hasClass('done')) {
                    $('.olena_blog_v9 .et_pb_post .post-meta').each(function () {
                        var author = $(this).find('span.author')[0];
                        var date = $(this).find('span.published')[0];
                        var categories = $(this).find('a[rel="tag"]').toArray();

                        var dateDay = $(this).find('.published').text();
                        var html = "";

                        var month = dateDay.replace(/\d+/g, '').replace(/,/g, "").replace(/ /g, "");
                        var day = dateDay.replace(/[^0-9.]/g, "");
                        var topDate = '<span class="top_date"><span class="day">' + day + '</span><span class="month">' + month + '</span></span>';

                        if (dateDay) {
                            html += topDate;
                        }

                        if (author) {
                            if (dateDay) {
                                html = topDate;
                                html += 'by ' + author.outerHTML;
                            } else {
                                html = 'by ' + author.outerHTML;
                            }
                        }

                        if (categories.length !== 0) {
                            categories = $.map(categories, function (element) {
                                return element.outerHTML;
                            });
                            categories = categories.join(', ');
                            html += "<span class='line'> | </span><span class='categories'>" + categories + "</span>";
                        }


                        $(this).html(html);
                    });


                    $('.olena_blog_v9 .et_pb_post').each(function () {
                        $(this).find('.top_date').insertBefore($(this).find('.entry-featured-image-url img'));
                    });


                    $('.olena_blog_v9 .et_pb_posts article').addClass('done');
                }
            }, 50);
        }


    }, olenaBlogV9);

})(jQuery);