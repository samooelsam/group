!function(a){a("body.search .et_pb_post .post-meta").each(function(){var s=a(this).find("span.author")[0],t=a(this).find("span.published")[0],n=a(this).find('a[rel="category tag"]').toArray(),e=a(this).find(".published").text(),p="",l=e.replace(/\d+/g,""),r=parseInt(e);(0!==n.length&&(p+="<span class='categories'>"+(n=(n=a.map(n,function(a){return a.outerHTML})).join(", "))+"</span><span class='line'>/</span>"),e)&&(p+=(t='<span class="published"><span class="day"> '+e+"</span></span>")+('<span class="top_date"><span class="day">'+r+'</span><span class="month">'+l+"</span></span>"));s&&(e?(p=t+'<span class="line">|</span>',p+=s.outerHTML):p=s.outerHTML),a(this).html(p)}),a("input,textarea").focus(function(){""!==a(this).attr("placeholder")&&(a(this).attr("data-placeholder",a(this).attr("placeholder")),a(this).attr("placeholder",""))}),a("input,textarea").blur(function(){""===a(this).attr("placeholder")&&a(this).attr("placeholder",a(this).attr("data-placeholder"))}),setInterval(function(){a("body.search .et_pb_posts article").hasClass("done")||(a("body.search .et_pb_post .post-meta").each(function(){var s=a(this).find("span.author")[0],t=a(this).find("span.published")[0],n=a(this).find('a[rel="category tag"]').toArray(),e=a(this).find(".published").text(),p="",l=e.replace(/\d+/g,""),r=parseInt(e);(0!==n.length&&(p+="<span class='categories'>"+(n=(n=a.map(n,function(a){return a.outerHTML})).join(", "))+"</span><span class='line'>/</span>"),e)&&(p+=(t='<span class="published"><span class="day"> '+e+"</span></span>")+('<span class="top_date"><span class="day">'+r+'</span><span class="month">'+l+"</span></span>"));s&&(e?(p=t+'<span class="line">|</span>',p+=s.outerHTML):p=s.outerHTML),a(this).html(p)}),a("body.search .et_pb_posts article").addClass("done"))},50)}(jQuery);