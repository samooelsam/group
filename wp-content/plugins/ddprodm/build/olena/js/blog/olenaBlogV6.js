(function ($) {

    function isIE() {
        ua = navigator.userAgent;
        var is_ie = ua.indexOf("MSIE ") > -1 || ua.indexOf("Trident/") > -1;

        return is_ie;
    }

    var olenaBlogV6 = 0;

    if (isIE()) {
        olenaBlogV6 = 5000;
    }

    if ($('body').hasClass('et-fb')) {
        olenaBlogV6 = 10000;
    }

    setTimeout(function () {

        if ($('.olena_blog_v6').length !== 0) {
            $('.olena_blog_v6 article.et_pb_post').each(function () {
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
                if (!$('.olena_blog_v6 .et_pb_posts article').hasClass('done')) {


                    $('.olena_blog_v6 .et_pb_post .post-meta').each(function () {
                        var metaHtml = "";
                        var author = $(this).find('span.author')[0];
                        var date = '<span class="published">'+ $(this).find('.published').text() +'</span>';
                        var categories = $(this).find('a[rel="tag"]').toArray();
                        if(author) {
                            $(this).find('span.author')[0].remove();
                        }
                        $(this).find('span.published')[0].remove();
                        $(this).find('a[rel="tag"]').remove();

                        categories = $.map(categories, function (element) {
                            return element.outerHTML;
                        });

                        var commentText = $(this).html().replace(/,/g, "").replace(/\|/g, "").replace(/by/g, "")


                        if(author){
                            metaHtml = author.outerHTML + date + commentText + categories
                        }else{
                            metaHtml = date + commentText + categories
                        }

                        $(this).html(metaHtml)
                    })

                    $('.olena_blog_v6 .et_pb_post').each(function () {
                        $('<div class="categories"></div>').insertBefore($(this).find('.entry-featured-image-url'));
                        $('<div class="blog_info"></div>').insertAfter($(this).find('.entry-featured-image-url'));
                        $(this).find('.entry-title').appendTo($(this).find('.blog_info'));
                        $(this).find('.post-meta').appendTo($(this).find('.blog_info'));
                        $(this).find('.post-meta a[rel="tag"]').appendTo($(this).find('.categories'));


                        $(this).find('.post-content').appendTo($(this).find('.blog_info'));
                        $(this).find('.more-link').insertAfter($(this).find('.blog_info'));

                        var imageSrc = $(this).find('.entry-featured-image-url img').attr('src');
                        $(this).find('.entry-featured-image-url').prepend($('<div class="bg_image"></div>'));
                        $(this).find('.entry-featured-image-url .bg_image').css('background-image', 'url(' + imageSrc + ')')
                    });

                    $('.olena_blog_v6 .et_pb_posts article').addClass('done');
                }
            }, 50);
        }


    }, olenaBlogV6);

})(jQuery);