!function(t){var e=2e3;ua=navigator.userAgent,(ua.indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(e=5e3),t("body").hasClass("et-fb")&&(e=1e4),setTimeout(function(){if(0!==t(".freddie_attraction_timeline").length){var e=0;t(".freddie_attraction_timeline .et_pb_tabs .et_pb_tab").each(function(){t('<div class="tab_left_content"></div>').insertBefore(t(this).find(".et_pb_tab_content")),t(t(this).find("strong")).appendTo(t(this).find(".tab_left_content")),t(this).find(".et_pb_tab_content").height()>t(this).find(".tab_left_content").height()?t(this).find(".tab_left_content").height(t(this).find(".et_pb_tab_content").height()):t(this).find(".et_pb_tab_content").height(t(this).find(".tab_left_content").height()),t(this).height()>e&&(e=t(this).height())}),t(".freddie_attraction_timeline .et_pb_tabs .et_pb_tab").height(e)}},e)}(jQuery);