!function(t){var e=0;((ua=navigator.userAgent).indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(e=5e3),t("body").hasClass("et-fb")&&(e=1e4),setTimeout(function(){0!==t(".olena_blog_v5").length&&setInterval(function(){if(!t(".olena_blog_v5 .et_pb_posts article").hasClass("done")){t(".olena_blog_v5 .et_pb_post .post-meta").each(function(){var e=t(this).find("span.author")[0];t(this).find("span.published")[0];var n=t(this).find('a[rel="tag"]').toArray(),i=t(this).find(".published").text(),a="",s=i.replace(/\d+/g,"").replace(/,/g,"").replace(/ /g,""),o='<span class="top_date"><span class="day">'+i.replace(/[^0-9.]/g,"")+'</span><span class="month">'+s+"</span></span>";i&&(a+=o),e&&(i?(a=o,a+="by "+e.outerHTML+'<span class="line"> | </span>'):a="by "+e.outerHTML+'<span class="line"> | </span>'),0!==n.length&&(a+="<span class='categories'>"+(n=(n=t.map(n,function(t){return t.outerHTML})).join(", "))+"</span>"),t(this).html(a)});var e=0;t(".olena_blog_v5 .et_pb_post").each(function(){t(this).find(".top_date").insertBefore(t(this).find(".entry-featured-image-url img")),t('<div class="blog_info"></div>').insertAfter(t(this).find(".entry-featured-image-url")),t(this).find(".post-meta").appendTo(t(this).find(".blog_info")),t(this).find(".entry-title").appendTo(t(this).find(".blog_info")),t(this).find(".post-content").appendTo(t(this).find(".blog_info"));var n=t(this).find(".entry-featured-image-url img").attr("src");t(this).find(".entry-featured-image-url").prepend(t('<div class="bg_image"></div>')),t(this).find(".entry-featured-image-url .bg_image").css("background-image","url("+n+")"),t(this).find(".entry-title a").height()>e&&(e=t(this).find(".entry-title a").height())}),t(".olena_blog_v5 .et_pb_post .entry-title a").height(e),t(".olena_blog_v5 .et_pb_posts article").addClass("done")}},50)},e)}(jQuery);