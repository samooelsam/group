jQuery(document).ready(function(e){setInterval(function(){if(e("ul[id^=sub-accordion-section-ddpdm]").hasClass("open")){var t=e(".control-section.open").attr("id");e("#"+t+" .ddpdm-click-on-load:not(.ddpdm-clicked)").trigger("click"),e("#"+t+" .ddpdm-click-on-load:not(.ddpdm-clicked)").addClass("ddpdm-clicked")}else{t=e(".control-section.open").attr("id");e("#"+t+" .ddpdm-click-on-load:not(.ddpdm-clicked)").removeClass("ddpdm-clicked")}if(!e("ul[id^=sub-accordion-section-ddpdm_mobile_menu_section]").hasClass("open")||e("button.preview-tablet").hasClass("active")||e("button.preview-tablet").hasClass("clicked")||(e("button.preview-tablet").click(),e("button.preview-tablet").addClass("clicked")),e("ul[id^=sub-accordion-section-ddpdm_mobile_menu_section]").hasClass("open")){e("#customize-preview iframe").attr("id","ddpdm-tablet-iframe");var o=document.getElementById("ddpdm-tablet-iframe"),c=o.contentWindow||o;o.contentDocument||c.document;function d(){!0===e("#_customize-input-ddpdm_mobile_menu_show_checkbox").prop("checked")?e("li#customize-control-ddpdm_mobile_menu_screen_size_range").addClass("ddpdm-setting-disabled"):e("li#customize-control-ddpdm_mobile_menu_screen_size_range").removeClass("ddpdm-setting-disabled")}iframeHtml=o.innerHTML,e("#customize-preview iframe").contents().find('.mobile_menu_bar_toggle:not(".changed")').click(),e("#customize-preview iframe").contents().find('.mobile_menu_bar_toggle:not(".changed")').addClass("changed"),d(),e("#_customize-input-ddpdm_mobile_menu_show_checkbox").on("change",function(){d()})}e("ul[id^=sub-accordion-section-ddpdm_back_to_top_section]").hasClass("open")&&(e("#customize-control-ddpdm_back_to_top_icon_change_option li:not(.ddpdm-et-icon)").hide(),e("#customize-preview iframe").contents().find("html:not(.scrolled):not(.os-html), body:not(.scrolled):not(.os-host)").animate({scrollTop:e("#customize-preview iframe").contents().height()/2},"fast"),e("#customize-preview iframe").contents().find("html:not(.os-html), body:not(.os-host)").addClass("scrolled"))},300),wp.customize.bind("ready",function(){wp.customize.control("ddpdm_search_results_select_box",function(e){e.setting.bind(function(e){switch(e){case"disabled":console.log("disabled"),wp.customize.control("ddpdm_search_results_header_color").deactivate(),wp.customize.control("ddpdm_search_results_header_size").deactivate(),wp.customize.control("ddpdm_search_results_header_font").deactivate(),wp.customize.control("ddpdm_search_results_header_font_select").deactivate(),wp.customize.control("ddpdm_search_results_meta_color").deactivate(),wp.customize.control("ddpdm_search_results_meta_size").deactivate(),wp.customize.control("ddpdm_search_results_content_color").deactivate(),wp.customize.control("ddpdm_search_results_content_size").deactivate(),wp.customize.control("ddpdm_search_results_body_font").deactivate(),wp.customize.control("ddpdm_search_results_body_font_select").deactivate(),wp.customize.control("ddpdm_search_results_rm_color").deactivate(),wp.customize.control("ddpdm_search_results_rm_size").deactivate(),wp.customize.control("ddpdm_search_results_line_color").deactivate(),wp.customize.control("ddpdm_search_results_line_size").deactivate();break;case"diana_1":console.log("diana_1"),wp.customize.control("ddpdm_search_results_header_color").activate(),wp.customize.control("ddpdm_search_results_header_size").activate(),wp.customize.control("ddpdm_search_results_header_font").activate(),wp.customize.control("ddpdm_search_results_header_font_select").activate(),wp.customize.control("ddpdm_search_results_meta_color").activate(),wp.customize.control("ddpdm_search_results_meta_size").activate(),wp.customize.control("ddpdm_search_results_content_color").activate(),wp.customize.control("ddpdm_search_results_content_size").activate(),wp.customize.control("ddpdm_search_results_body_font").activate(),wp.customize.control("ddpdm_search_results_body_font_select").activate(),wp.customize.control("ddpdm_search_results_rm_color").activate(),wp.customize.control("ddpdm_search_results_rm_size").activate(),wp.customize.control("ddpdm_search_results_line_color").activate(),wp.customize.control("ddpdm_search_results_line_size").activate()}})}),wp.customize.control("ddpdm_pop_up_clear_cookie_button",function(t){t.container.find(".button").on("click",function(){e.cookie("ddpdm_pop_up_cookie",null,{path:"/"}),location.reload()})})})});