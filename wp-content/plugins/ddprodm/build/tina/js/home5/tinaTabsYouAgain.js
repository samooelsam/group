!function(t){var a=2e3;ua=navigator.userAgent,(ua.indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(a=5e3),t("body").hasClass("et-fb")&&(a=1e4),setTimeout(function(){if(0!==t(".tina_you_again_tabs").length){var a=0;t(".tina_you_again_tabs .et_pb_all_tabs .et_pb_tab").each(function(){t(this).find("img").unwrap(),t('<div class="tab_image"></div>').insertBefore(t(this).find(".et_pb_tab_content")),t(this).find("img").appendTo(t(this).find(".tab_image")),t(this).attr("height-size",t(this).outerHeight()),a<t(this).outerHeight()&&(a=t(this).outerHeight()),t(this).css("height",0)}),t(".tina_you_again_tabs .et_pb_tabs .et_pb_tabs_controls li:first-child").addClass("active_li"),t(".tina_you_again_tabs .et_pb_all_tabs").height(a),t(".tina_you_again_tabs .et_pb_tabs .et_pb_tab.et-pb-active-slide").css("height",t(".tina_you_again_tabs .et_pb_tabs .et_pb_tab.et-pb-active-slide").attr("height-size"));var _=t(".tina_you_again_tabs .et_pb_tabs .et_pb_tabs_controls").css("top");_=parseInt(_,10),t(".tina_you_again_tabs .et_pb_tabs .et_pb_tabs_controls a").on("click",function(){t(this);setTimeout(function(){console.log("clicked"),t(".tina_you_again_tabs .et_pb_tabs .et_pb_tabs_controls li").removeClass("active_li"),t(".tina_you_again_tabs .et_pb_tabs .et_pb_tabs_controls li.et_pb_tab_active").addClass("active_li");var a=t(".tina_you_again_tabs .et_pb_tabs .et_pb_tabs_controls li.active_li").prevAll().length,i=t(".tina_you_again_tabs .et_pb_tabs .et_pb_tabs_controls li").outerHeight(),e=_-a*i;t(".tina_you_again_tabs .et_pb_tabs .et_pb_tabs_controls").css("top",e),t(".tina_you_again_tabs .et_pb_tabs .et_pb_tab").css("height",0),t(".tina_you_again_tabs .et_pb_tabs .et_pb_tab.et-pb-active-slide").css("height",t(".tina_you_again_tabs .et_pb_tabs .et_pb_tab.et-pb-active-slide").attr("height-size"))},0)})}},a)}(jQuery);