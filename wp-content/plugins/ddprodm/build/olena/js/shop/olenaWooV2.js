!function(e){var t=0;((ua=navigator.userAgent).indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(t=5e3),e("body").hasClass("et-fb")&&(t=1e4),setTimeout(function(){if(0!==e(".olena_woo_v2").length){window.location.href,e("#page-container .olena_woo_v2 .et_pb_shop li.product").each(function(){for(var t,o="post-",i=e(this).attr("class").split(" "),n=0;n<i.length;n++)if(i[n].indexOf(o)>-1){t=i[n].slice(o.length,i[n].length);break}var a=e(this).find(".et_shop_image img").attr("src"),s=e(this).find(".et_shop_image img").attr("srcset");s=(a=a.replace(/-([0-9][0-9][0-9]x[0-9][0-9])\w+/g,"")).replace(/-([0-9][0-9][0-9]x[0-9][0-9])\w+/g,""),e(this).find(".et_shop_image img").attr("src",a),e(this).find(".et_shop_image img").attr("srcset",s),e("body:not(.et-fb)").find(".olena_woo_v2 .et_pb_column > .et_pb_code").clone().appendTo(e(this).find(".et_shop_image"))}),e("body:not(.et-fb)").find(".olena_woo_v2 .et_pb_column > .et_pb_code").remove(),e("#page-container .olena_woo_v2 .filter_col").prepend(e('<div class="product_filter"><ul></ul></div>'));var t="product_cat-";function o(e){for(var t={},o=0;o<e.length;o++)t[e[o]]=!0;var i=[];for(var n in t)i.push(n);return i}e("#page-container .olena_woo_v2 li.product").each(function(){e('<div class="categories"></div>').appendTo(e(this).find(".et_shop_image"));for(var o=e(this).attr("class").split(" "),i=0;i<o.length;i++)o[i].indexOf(t)>-1&&e('<li postClass="'+o[i].slice(t.length,o[i].length)+'"><a class="category_link" href="/product-category/'+o[i].slice(t.length,o[i].length)+'/">'+o[i].slice(t.length,o[i].length).replace("-"," ")+"</a></li>").appendTo(e(this).find(".categories"))})}},t)}(jQuery);