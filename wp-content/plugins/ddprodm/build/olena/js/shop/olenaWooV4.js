!function(e){var t=0;((ua=navigator.userAgent).indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(t=5e3),e("body").hasClass("et-fb")&&(t=1e4),setTimeout(function(){if(0!==e(".olena_woo_v4").length){var t=window.location.href;e("#page-container .olena_woo_v4 .et_pb_shop li.product").each(function(){for(var a,i="post-",o=e(this).attr("class").split(" "),n=0;n<o.length;n++)if(o[n].indexOf(i)>-1){a=o[n].slice(i.length,o[n].length);break}var s=e(this).find(".et_shop_image img").attr("src"),l=e(this).find(".et_shop_image img").attr("srcset");l=(s=s.replace(/-([0-9][0-9][0-9]x[0-9][0-9])\w+/g,"")).replace(/-([0-9][0-9][0-9]x[0-9][0-9])\w+/g,""),e(this).find(".et_shop_image img").attr("src",s),e(this).find(".et_shop_image img").attr("srcset",l),e('<a class="add_to_cart" href="'+t+"/?add-to-cart="+a+'"></a>').appendTo(e(this)),e("body:not(.et-fb)").find(".olena_woo_v4 .et_pb_column > .et_pb_code").clone().appendTo(e(this).find(".add_to_cart"))}),e("body:not(.et-fb)").find(".olena_woo_v4 .et_pb_column > .et_pb_code").remove();var a="product_cat-",i="product_tag-";function o(e){for(var t={},a=0;a<e.length;a++)t[e[a]]=!0;var i=[];for(var o in t)i.push(o);return i}e("#page-container .olena_woo_v4 li.product").each(function(){e('<div class="categories"></div>').insertBefore(e(this).find(".woocommerce-loop-product__title"));for(var t=e(this).attr("class").split(" "),o=0;o<t.length;o++)if(t[o].indexOf(i)>-1){e('<div class="tags"></div>').appendTo(e(this).find(".et_shop_image"));break}for(var o=0;o<t.length;o++)t[o].indexOf(a)>-1&&e('<li postClass="'+t[o].slice(a.length,t[o].length)+'"><a class="category_link" href="/product-category/'+t[o].slice(a.length,t[o].length)+'/">'+t[o].slice(a.length,t[o].length).replace("-"," ")+"</a></li>").appendTo(e(this).find(".categories")),t[o].indexOf(i)>-1&&e('<li postClass="'+t[o].slice(i.length,t[o].length)+'"><a class="tag_link" href="/product-tag/'+t[o].slice(i.length,t[o].length)+'/">'+t[o].slice(i.length,t[o].length).replace("-"," ")+"</a></li>").appendTo(e(this).find(".tags"))})}},t)}(jQuery);