!function(t){var e=2e3;ua=navigator.userAgent,(ua.indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(e=5e3),t("body").hasClass("et-fb")&&(e=1e4),setTimeout(function(){if(0!==t(".tina_accordion_looked_down").length){t(".tina_accordion_looked_down .et_pb_accordion .et_pb_toggle_open").addClass("et_pb_toggle_close").removeClass("et_pb_toggle_open"),t(".tina_accordion_looked_down .et_pb_toggle").each(function(){t(this).find(".et_pb_toggle_content").attr("height",t(this).find(".et_pb_toggle_content").height()),t(this).find(".et_pb_toggle_content").css("cssText","max-height: 0 !important;"),t(this).attr("height",t(this).outerHeight()),t(this).attr("margin-bottom",parseInt(t(this).css("margin-bottom"),10));var e=0;0!==t(this).prevAll().length&&t(this).prevAll().each(function(){e+=parseInt(t(this).attr("height"))+parseInt(t(this).attr("margin-bottom"))}),t(this).css("top",e);var o=t(this).css("background-image");t(this).css("background-image","none"),"none"!==(o=o.replace("url(","").replace(")","").replace(/\"/gi,""))&&t('<div class="image_box"><img src="'+o+'"></div>').insertBefore(t(this).find(".et_pb_toggle_title"))});var e=t(".tina_accordion_looked_down .et_pb_accordion").height();t(".tina_accordion_looked_down .et_pb_accordion .et_pb_toggle").css("position","absolute"),t(".tina_accordion_looked_down .accordion_col").height(e),t(".tina_accordion_looked_down .et_pb_toggle_title").click(function(t){t.preventDefault()}),t(".tina_accordion_looked_down .et_pb_toggle").click(function(e){t(".tina_accordion_looked_down .et_pb_toggle").each(function(){t(this).removeClass("et_pb_toggle_close"),t(this).removeClass("et_pb_toggle_open"),t(this).find(".et_pb_toggle_content").css("cssText"," max-height: 0 !important;")});var o=t(this);if(o.hasClass("opened"))t(".tina_accordion_looked_down .et_pb_toggle").removeClass("closed"),o.removeClass("opened"),o.find(".et_pb_toggle_content").css("cssText","max-height: 0px !important;");else{t(".tina_accordion_looked_down .et_pb_toggle").removeClass("opened");o.prevAll().each(function(){parseInt(t(this).attr("height"))+parseInt(t(this).attr("margin-bottom"))}),t(".tina_accordion_looked_down .et_pb_toggle").addClass("closed"),o.addClass("opened"),setTimeout(function(){o.find(".et_pb_toggle_content").css("cssText","max-height: "+o.find(".et_pb_toggle_content").attr("height")+"px !important;")},50)}}),t(".tina_accordion_looked_down .et_pb_accordion").css("opacity",1)}},e)}(jQuery);