!function(t){var e=0;((ua=navigator.userAgent).indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(e=5e3),t("body").hasClass("et-fb")&&(e=1e4),setTimeout(function(){if(0!==t(".olena_woo_v10").length){var e=window.location.href;t("#page-container .olena_woo_v10 .et_pb_shop li.product").each(function(){for(var i,a="post-",n=t(this).attr("class").split(" "),s=0;s<n.length;s++)if(n[s].indexOf(a)>-1){i=n[s].slice(a.length,n[s].length);break}var o=t(this).find(".et_shop_image img").attr("src"),r=t(this).find(".et_shop_image img").attr("srcset");r=(o=o.replace(/-([0-9][0-9][0-9]x[0-9][0-9])\w+/g,"")).replace(/-([0-9][0-9][0-9]x[0-9][0-9])\w+/g,""),t(this).find(".et_shop_image img").attr("src",o),t(this).find(".et_shop_image img").attr("srcset",r),t('<div class="bottom_cont"><a class="add_to_cart" href="'+e+"/?add-to-cart="+i+'"></a></div>').appendTo(t(this).find(".et_shop_image")),t(this).find(".price ins").insertBefore(t(this).find(".price del"))});var i="product_cat-",a="product_tag-";function n(t){for(var e={},i=0;i<t.length;i++)e[t[i]]=!0;var a=[];for(var n in e)a.push(n);return a}t("#page-container .olena_woo_v10 li.product").each(function(){t('<div class="categories"></div>').appendTo(t(this).find(".bottom_cont"));for(var e=t(this).attr("class").split(" "),n=0;n<e.length;n++)if(e[n].indexOf(a)>-1){t('<div class="tags"></div>').appendTo(t(this).find(".et_shop_image"));break}for(var n=0;n<e.length;n++)e[n].indexOf(i)>-1&&t('<li postClass="'+e[n].slice(i.length,e[n].length)+'"><a class="category_link" href="/product-category/'+e[n].slice(i.length,e[n].length)+'/">'+e[n].slice(i.length,e[n].length).replace("-"," ")+"</a></li>").appendTo(t(this).find(".categories")),e[n].indexOf(a)>-1&&t('<li postClass="'+e[n].slice(a.length,e[n].length)+'"><a class="tag_link" href="/product-tag/'+e[n].slice(a.length,e[n].length)+'/">'+e[n].slice(a.length,e[n].length).replace("-"," ")+"</a></li>").appendTo(t(this).find(".tags"))})}},e)}(jQuery);