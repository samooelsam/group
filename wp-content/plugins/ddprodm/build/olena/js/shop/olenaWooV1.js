!function(t){var e=0;((ua=navigator.userAgent).indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(e=5e3),t("body").hasClass("et-fb")&&(e=1e4),setTimeout(function(){if(0!==t(".olena_woo_v1").length){var e=window.location.href;t("#page-container .olena_woo_v1 .et_pb_shop li.product").each(function(){for(var a,o="post-",i=t(this).attr("class").split(" "),s=0;s<i.length;s++)if(i[s].indexOf(o)>-1){a=i[s].slice(o.length,i[s].length);break}t('<a class="add_to_cart" href="'+e+"/?add-to-cart="+a+'"></a>').appendTo(t(this).find(".et_shop_image"));var l=t(this).find(".et_shop_image img").attr("src"),n=t(this).find(".et_shop_image img").attr("srcset");n=(l=l.replace(/-([0-9][0-9][0-9]x[0-9][0-9])\w+/g,"")).replace(/-([0-9][0-9][0-9]x[0-9][0-9])\w+/g,""),t(this).find(".et_shop_image img").attr("src",l),t(this).find(".et_shop_image img").attr("srcset",n)}),t("#page-container .olena_woo_v1 .filter_col").prepend(t('<div class="product_filter"><ul></ul></div>'));var a="product_cat-",o=[];t("#page-container .olena_woo_v1 li.product").each(function(){for(var e=t(this).attr("class").split(" "),i=0;i<e.length;i++)e[i].indexOf(a)>-1&&(t(this).attr("id",e[i].slice(a.length,e[i].length)),o.push(e[i].slice(a.length,e[i].length)))}),o=function t(e){for(var a={},o=0;o<e.length;o++)a[e[o]]=!0;var i=[];for(var s in a)i.push(s);return i}(o);for(var i=0;i<o.length;i++)t('<li postClass="'+o[i]+'">'+o[i].replace("-"," ")+"</li>").appendTo(t("#page-container .olena_woo_v1 .filter_col ul"));t("#page-container .olena_woo_v1 .filter_col li:first-child").addClass("active_menu_item");var s=t("#page-container .olena_woo_v1 .filter_col li:first-child").attr("postclass");t("#page-container .olena_woo_v1 li.type-product").addClass("deactive_post"),t("#page-container .olena_woo_v1 li.type-product").each(function(){t(this).hasClass("product_cat-"+s)&&(t(this),t(this).removeClass("deactive_post"),t(this).addClass("active_post"))}),t("#page-container .olena_woo_v1 .product_filter li").on("click",function(){t("#page-container .olena_woo_v1 li.type-product").css("transition-delay","0.4s"),t("#page-container .olena_woo_v1 .product_filter li").removeClass("active_menu_item"),t(this).addClass("active_menu_item");var e=t(this).attr("postclass");if(t(".olena_woo_v1 ul.products").addClass("filter_clicked"),t(".olena_woo_v1 .et_pb_posts").addClass("load_posts"),"all"===e)setTimeout(function(){t("#page-container .olena_woo_v1 li.type-product").removeClass("deactive_post"),t("#page-container .olena_woo_v1 li.type-product").addClass("active_post");for(var e=0,a=0;a<=t("#page-container .olena_woo_v1 li.type-product").length;a++)t("#page-container .olena_woo_v1 li.type-product:nth-child("+a+")").css("transition-delay",e+"s"),e+=.05},500);else{var a=0;t("#page-container .olena_woo_v1 li.type-product").each(function(){if(t(this).hasClass("product_cat-"+e)){var o=t(this);setTimeout(function(){o.removeClass("deactive_post"),o.addClass("active_post"),o.css("transition-delay",a+"s"),a+=.05},300)}else{var o=t(this);setTimeout(function(){o.removeClass("active_post"),o.addClass("deactive_post")},300)}})}setTimeout(function(){t(".olena_woo_v1 ul.products").removeClass("filter_clicked"),t(".olena_woo_v1 .et_pb_posts").removeClass("load_posts")},700)})}},e)}(jQuery);