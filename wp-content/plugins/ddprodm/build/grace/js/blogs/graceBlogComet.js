!function(e){var t=500;ua=navigator.userAgent,(ua.indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(t=5e3),e("body").hasClass("et-fb")&&(t=1e4),setTimeout(function(){0!==e(".grace_blog_comet").length&&(e(".grace_blog_comet article.et_pb_post").each(function(){var t=e(this).find(".entry-featured-image-url img").attr("src");e(this).find(".entry-featured-image-url").html('<div class="inner_image_box"><div class="bg_image_box"></div></div>'),e(this).find(".bg_image_box").css("background-image","url("+t+")")}),e("#page-container .grace_blog_comet  article.et_pb_post .post-meta").each(function(){e(this).html(e(this).html().replace(/\|/g,"").replace("by",""))}),e("#page-container .grace_blog_comet  article.et_pb_post").on("click",function(){window.location.href=e(this).find(".entry-title a").attr("href")}))},t)}(jQuery);