!function(t){var e=1e3;ua=navigator.userAgent,(ua.indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(e=1e4),t("body").hasClass("et-fb")&&(e=1e4),t("body").hasClass("et-tb")&&(e=15e3),setTimeout(function(){if(0!==t(".freddie_thunderbolt_product").length){if(t('<div class="quantity-nav"><div class="quantity-button quantity-up">B</div><div class="quantity-button quantity-down">C</div></div>').insertAfter("body .freddie_thunderbolt_product .quantity input"),t("body.single-product .quantity").each(function(){var e=t(this),i=e.find('input[type="number"]'),d=e.find(".quantity-up"),r=e.find(".quantity-down"),o=i.attr("min");i.attr("max");d.click(function(){var t=parseFloat(i.val())+1;e.find("input").val(t),e.find("input").trigger("change")}),r.click(function(){var t=parseFloat(i.val());if(t<=o)var d=t;else d=t-1;e.find("input").val(d),e.find("input").trigger("change")})}),setTimeout(function(){t(".freddie_thunderbolt_product .flex-control-nav.flex-control-thumbs").insertBefore(".freddie_thunderbolt_product .flex-viewport");var e=t(".freddie_thunderbolt_product .flex-control-nav.flex-control-thumbs").height(),i=t(".freddie_thunderbolt_product .flex-control-nav.flex-control-thumbs li").length;t(".freddie_thunderbolt_product .flex-control-nav.flex-control-thumbs li").height(e/i-20),t(".freddie_thunderbolt_product .flex-control-nav.flex-control-thumbs li").each(function(){var e=t(this).find("img").attr("src");e=e.replace(/-([0-9][0-9][0-9]x[0-9][0-9])\w+/g,""),t(this).css("background-image","url("+e+")")})},1e3),t(".freddie_thunderbolt_product .flex-control-nav.flex-control-thumbs li").each(function(){var e=t(this).find("img").attr("src");e=e.replace(/-([0-9][0-9][0-9]x[0-9][0-9])\w+/g,""),t(this).find("img").attr("src",e)}),t(".freddie_thunderbolt_product .flex-control-nav.flex-control-thumbs li").on("click",function(){var e=t(this),i=t(this).find("img").attr("src");setTimeout(function(){t(".freddie_thunderbolt_product .woocommerce-product-gallery__image").each(function(){if(t(this).find("img").attr("src")===i){var e=t(this).offset().top-50;t("html, body").stop().animate({scrollTop:e},800,"swing",function(){})}}),t(".freddie_thunderbolt_product .flex-control-nav.flex-control-thumbs li").removeClass("active_item"),e.find("img").hasClass("flex-active")&&e.addClass("active_item")},50)}),0!==t(".circle_text_blurb").length){t("body .freddie_thunderbolt_product .circle_text_blurb").hover(function(){t(this).find("h4.et_pb_module_header").animate({opacity:1,display:"inline-block",width:"toggle",height:"toggle"},400),t(this).find("h4.et_pb_module_header").css("display","inline-block")},function(){t(this).find("h4.et_pb_module_header").animate({opacity:0,display:"none",width:"toggle",height:"toggle"},400)}),t("body .freddie_thunderbolt_product .circle_text_blurb .et_pb_blurb_description").each(function(){0!==t(this).find("p").length?t(this).find("p").addClass("circle_text"):(t(this).contents().filter(function(){return 3===this.nodeType}).wrap("<div class='circle_text'></div>"),t(this).find(".circle_text:nth-child(1)").remove());var e=t(this).find(".circle_text").text();e=e.replace(/ /g,"&nbsp;"),t(this).find(".circle_text").html(e)});for(var e=new SplitText("body .freddie_thunderbolt_product .circle_text_blurb .circle_text",{type:"chars",charsClass:"char char++",position:"absolute"}),i=t("body .freddie_thunderbolt_product .circle_text_blurb .char"),d=0;d<i.length;d++)i[d].style.display="inline",i[d].style.width="100%",i[d].style.top=0,i[d].style.left=0;var r=new TimelineLite,o=(e.chars,t("body .freddie_thunderbolt_product .circle_text_blurb .circle_text"));TweenLite.set("body .freddie_thunderbolt_product .circle_text_blurb .circle_text",{perspective:400});var l=i.length,s=350/l;for(d=1;d<=l;d++)t("body .freddie_thunderbolt_product .circle_text_blurb .char:nth-child("+d+")").css("transform","rotate("+s*d+"deg)");r.to(o,30,{rotation:"360",repeat:-1,ease:Linear.easeNone},0)}function n(){t(window).height();var e=t(window).scrollTop();0!==t(".freddie_thunderbolt_product ").length&&t(".freddie_thunderbolt_product .woocommerce-product-gallery__image").each(function(){var i=t(this).offset().top;if(parseInt(i)<=parseInt(e)+50){var d=t(this).find("img").attr("src");d&&t(".freddie_thunderbolt_product .flex-control-thumbs li").each(function(){t(this).find("img").attr("src")===d&&(t(".freddie_thunderbolt_product .flex-control-thumbs li").removeClass("active_item"),t(this).addClass("active_item"))})}})}if(n(),t(window).scroll(function(){n()}),t("body").hasClass("os-host"))OverlayScrollbars(t("body"),{callbacks:{onScroll:function(){n()}}});if(t(".freddie_thunderbolt_product").css("opacity",1),0!==t(".freddie_little_silhouetto_related_products").length){var c=window.location.href;"/"===(c=c.split("/?")[0]).substr(c.length-1)&&(c=c.slice(0,-1));var a=2;t(window).width()<=767&&(a=1),t(".freddie_little_silhouetto_related_products .et_pb_shop li.product").each(function(){for(var e,i=t(this).attr("class").split(" "),d=0;d<i.length;d++)if(i[d].indexOf("post-")>-1){e=i[d].slice("post-".length,i[d].length);break}t(this).find("span.price").appendTo(t(this).find(".et_shop_image")),t(this).closest(".et_pb_shop").hasClass("products_slider_2_col")?t('<a class="add_to_cart" href="'+c+"/?add-to-cart="+e+'"></a>').appendTo(t(this).find(".et_shop_image")):t('<a class="add_to_cart" href="'+c+"/?add-to-cart="+e+'"></a>').insertAfter(t(this).find(".et_shop_image"))}),t(".freddie_little_silhouetto_related_products").each(function(){t(this).find(".et_pb_shop").each(function(){t(this).hasClass("products_slider_1_col")&&(a=1),t(this).find(" li.product:first-child").addClass("active_slide");var e=t(this).width(),i=t(this).find("li.product").length,d=e/a,r=i*d;t(this).find("li.product").css("cssText","width: "+d+"px !important"),t(this).find("ul.products ").width(r),t('<div class="slide_dots"></div>').appendTo(t(this)),t(this).hasClass("products_slider_2_col")&&t(window).width()>=768&&(i-=1);for(var o=1;o<=i;o++)t('<div class="slide_dot">'+o+"</div>").appendTo(t(this).find(".slide_dots"))})}),t(".freddie_little_silhouetto_related_products .et_pb_shop .slide_dot:first-child").addClass("active_dot"),t(".freddie_little_silhouetto_related_products .et_pb_shop .slide_dot").on("click",function(e){e.preventDefault(),t(this).closest(".et_pb_shop").find(".slide_dot").removeClass("active_dot"),t(this).addClass("active_dot");var i=t(this).prevAll().length,d=t(this);setTimeout(function(){var t=d.closest(".et_pb_shop").find("li.product").width();d.closest(".et_pb_shop").find("ul.products").css("transform","translate(-"+i*t+"px, 0)")},100)})}}},e)}(jQuery);