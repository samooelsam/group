!function(e){var t=0;ua=navigator.userAgent,(ua.indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(t=5e3),e("body").hasClass("et-fb")&&(t=1e4),setTimeout((function(){0!==e(".olena_content_5").length&&e(".olena_content_5 .et_pb_toggle_title").click((function(){e(".et_pb_toggle_title").removeClass("opened"),e(this).addClass("opened");var t=e(this).closest(".et_pb_toggle");if(!t.hasClass("et_pb_accordion_toggling")){var o=t.closest(".et_pb_accordion");t.hasClass("et_pb_toggle_open")&&(o.addClass("et_pb_accordion_toggling"),t.find(".et_pb_toggle_content").slideToggle(700,(function(){t.removeClass("et_pb_toggle_open").addClass("et_pb_toggle_close")}))),setTimeout((function(){o.removeClass("et_pb_accordion_toggling")}),750)}}))}),t)}(jQuery);