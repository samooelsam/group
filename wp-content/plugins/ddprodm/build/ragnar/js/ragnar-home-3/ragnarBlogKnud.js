!function(s){var a=1e3;ua=navigator.userAgent,(ua.indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(a=1e4),s("body").hasClass("et-fb")&&(a=1e4),setTimeout(function(){0!==s(".ragnar_blog_knud").length&&(s(".ragnar_blog_knud .et_pb_posts  .et_pb_post  .post-meta").each(function(){var a=s(this).find("span.author")[0],t=s(this).find("span.published")[0],n=s(this).find('a[rel="tag"]').toArray(),e=s(this).find(".published").text(),i=e.replace(/\d+/g,""),p=parseInt(e);if(p<=9&&(p="0"+p),e&&(t='<span class="published"><span class="day"> '+p+'</span><span class="month"> '+i+"</span></span>"),n&&(n=(n=s.map(n,function(s){return s.outerHTML})).join(", ")),a){var r=a.outerHTML;r+=t}else r=t;r+="<span class='categories'>"+n+"</span>",s(this).html(r)}),setInterval(function(){s("body.et-fb .ragnar_blog_knud .et_pb_posts  .et_pb_post  .post-meta").each(function(){if(!s(this).hasClass("div_added")){var a=s(this).find("span.author")[0],t=s(this).find("span.published")[0],n=s(this).find('a[rel="tag"]').toArray(),e=s(this).find(".published").text(),i=e.replace(/\d+/g,""),p=parseInt(e);if(p<=9&&(p="0"+p),e&&(t='<span class="published"><span class="day"> '+p+'</span><span class="month"> '+i+"</span></span>"),n&&(n=(n=s.map(n,function(s){return s.outerHTML})).join(", ")),a){var r='<span class="auther_posted">Posted</span> '+a.outerHTML;r+=t}else r=t;r+="<span class='categories'>"+n+"</span>",s(this).html(r),s(this).find(".categories").insertBefore(s(this).find(".published")),s(this).prependTo(s(this).parent(".et_pb_post")),s(this).addClass("div_added")}})},200))},a)}(jQuery);