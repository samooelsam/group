!function(t){var i=3e3;ua=navigator.userAgent,(ua.indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(i=5e3),t("body").hasClass("et-fb")&&(i=1e4),setTimeout(function(){0!=t(".grace_blurbs_albaldah").length&&(t(".grace_blurbs_albaldah .et_pb_column .et_pb_blurb .et_pb_blurb_description").each(function(){var i=t(this).height();t(this).attr("dscription-height",i);var e=t(this).html();t(this).html('<div class="description_inner_cont">'+e+"</div>"),t(this).css("max-height",t(this).find(".et_pb_blurb_description").attr("dscription-height")+"px")}),t(".grace_blurbs_albaldah .et_pb_column .et_pb_blurb").hover(function(){t(this).find(".et_pb_blurb_description").css("max-height",0)},function(){t(this).find(".et_pb_blurb_description").css("max-height",t(this).find(".et_pb_blurb_description").attr("dscription-height")+"px")}),t(".grace_blurbs_albaldah .et_pb_blurb .et_pb_blurb_container").css("opacity",1))},i)}(jQuery);