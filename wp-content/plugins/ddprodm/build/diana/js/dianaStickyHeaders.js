!function(e){var t=ddpdm_php_vars.ddpdm_sticky_bar_scroll_per;function d(){var d=e(window).height(),i=e(document).height(),o=e(window).scrollTop(),n=i-d;if(Math.floor(o/n*100)>=t&&("ddpStickyBarCookie"!==e.cookie("notice")&&(e("body #main-header").addClass("notice_is_exist"),e("body #page-container").addClass("notice_is_exist")),"bottom"!==ddpdm_php_vars.ddpdm_sticky_bar_position)){var _=e("#page-container.notice_is_exist .ddpdm_header_top_section").height();e("body:not(.et_fixed_nav):not(.et-fb) #page-container.notice_is_exist .ddpdm_header_top_section+div:not(.et-fixed-header), body:not(.et_fixed_nav):not(.et-fb) #page-container.notice_is_exist .ddpdm_header_top_section+header:not(.et-fixed-header), body.et_fixed_nav.page-template-page-template-blank #page-container.notice_is_exist .ddpdm_header_top_section+div").css("padding-top",_+"px")}}"1"===ddpdm_php_vars.ddpdm_sticky_show_scroll&&(d(),e(window).on("scroll",function(){d()})),e("body #page-container.notice_is_exist > .et-fixed-header").css("padding-top",0),e(window).on("scroll",function(){e("body #page-container.notice_is_exist > .et-fixed-header").css("padding-top",0);var t=e("#page-container.notice_is_exist .ddpdm_header_top_section").height();e("body:not(.et_fixed_nav):not(.et-fb) #page-container.notice_is_exist .ddpdm_header_top_section+div:not(.et-fixed-header), body:not(.et_fixed_nav):not(.et-fb) #page-container.notice_is_exist .ddpdm_header_top_section+header:not(.et-fixed-header), body.et_fixed_nav.page-template-page-template-blank #page-container.notice_is_exist .ddpdm_header_top_section+div").css("padding-top",t+"px")}),e("body:not(.et-fb) .ddpdm_header_top_section").insertBefore("#page-container > :first-child"),e(".ddpdm_header_top_section a.close_icon").on("click",function(){"ddpStickyBarCookie"!==e.cookie("notice")&&(e(".ddpdm_header_top_section").slideUp(),e(".ddpdm_header_top_section+div, .ddpdm_header_top_section+header").css("cssText","padding-top: 0 !important"),e("body #main-header").removeClass("notice_is_exist"),e("body #page-container").removeClass("notice_is_exist"),e.cookie("notice","ddpStickyBarCookie",{expires:parseInt(ddpdm_php_vars.ddpdm_sticky_cookie_days),path:"/"}))}),"1"!==ddpdm_php_vars.ddpdm_sticky_show_leave&&"1"!==ddpdm_php_vars.ddpdm_sticky_show_scroll?setTimeout(function(){"ddpStickyBarCookie"!==e.cookie("notice")&&(e("body #main-header").addClass("notice_is_exist"),e("body #page-container").addClass("notice_is_exist"))},1e3*ddpdm_php_vars.ddpdm_sticky_delay):"1"===ddpdm_php_vars.ddpdm_sticky_show_leave&&e("html").mouseleave(function(){if("ddpStickyBarCookie"!==e.cookie("notice")&&(e("body #main-header").addClass("notice_is_exist"),e("body #page-container").addClass("notice_is_exist")),"bottom"!==ddpdm_php_vars.ddpdm_sticky_bar_position){var t=e("#page-container.notice_is_exist .ddpdm_header_top_section").height();e("body:not(.et_fixed_nav):not(.et-fb) #page-container.notice_is_exist .ddpdm_header_top_section+div:not(.et-fixed-header), body:not(.et_fixed_nav):not(.et-fb) #page-container.notice_is_exist .ddpdm_header_top_section+header:not(.et-fixed-header), body.et_fixed_nav.page-template-page-template-blank #page-container.notice_is_exist .ddpdm_header_top_section+div").css("padding-top",t+"px")}});var i=e(".et_pb_countdown_timer .days .value");i.each(function(){var t=e(this);t.after(t.clone()),t.next().wrap("<span></span>")}).hide(),function t(){i.each(function(){var t=e(this),d=t.html();"0"===d.substr(0,1)&&(d=d.slice(1)),t.next().find(".value").html(d)}),setTimeout(function(){t()},1e3)}(),e("body .et_pb_promo.cta_hover").hover(function(){e(this).find(".et_pb_promo_description strong").show(300)},function(){e(this).find(".et_pb_promo_description strong").hide(300)})}(jQuery);