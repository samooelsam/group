!function(t){var i=0;((ua=navigator.userAgent).indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(i=5e3),t("body").hasClass("et-fb")&&(i=1e4),setTimeout(function(){if(0!==t(".olena_woo_v12").length){var i=window.location.href;t("#page-container .olena_woo_v12 .et_pb_shop li.product").each(function(){for(var e,a="post-",n=t(this).attr("class").split(" "),s=0;s<n.length;s++)if(n[s].indexOf(a)>-1){e=n[s].slice(a.length,n[s].length);break}var r=t(this).find(".et_shop_image img").attr("src"),o=t(this).find(".et_shop_image img").attr("srcset");o=(r=r.replace(/-([0-9][0-9][0-9]x[0-9][0-9])\w+/g,"")).replace(/-([0-9][0-9][0-9]x[0-9][0-9])\w+/g,""),t(this).find(".et_shop_image img").attr("src",r),t(this).find(".et_shop_image img").attr("srcset",o),t('<div class="bottom_box"></div>').insertAfter(t(this).find(".price")),t('<a class="add_to_cart" href="'+i+"/?add-to-cart="+e+'"></a>').appendTo(t(this).find(".bottom_box")),t(this).find(".price").appendTo(t(this).find(".bottom_box")),t(this).find(".price ins").insertBefore(t(this).find(".price del"))});var e="product_tag-";function a(t){for(var i={},e=0;e<t.length;e++)i[t[e]]=!0;var a=[];for(var n in i)a.push(n);return a}t("#page-container .olena_woo_v12 li.product").each(function(){for(var i=t(this).attr("class").split(" "),a=0;a<i.length;a++)if(i[a].indexOf(e)>-1){t('<div class="tags"></div>').appendTo(t(this).find(".et_shop_image"));break}for(var a=0;a<i.length;a++)i[a].indexOf(e)>-1&&t('<li postClass="'+i[a].slice(e.length,i[a].length)+'"><a class="tag_link" href="/product-tag/'+i[a].slice(e.length,i[a].length)+'/">'+i[a].slice(e.length,i[a].length).replace("-"," ")+"</a></li>").appendTo(t(this).find(".tags"))})}},i)}(jQuery);