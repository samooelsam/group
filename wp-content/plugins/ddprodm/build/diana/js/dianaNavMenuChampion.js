!function(n){var e=1e3;n("body").hasClass("et-fb")&&(e=1e4),n("body").hasClass("et-tb")&&(dianaMenueFirstTimeOut=1e4),ua=navigator.userAgent,(ua.indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(e=5e3),setTimeout(function(){if(0!==n(".diana_champion_menu").length&&(n("#custom-ddp-menu").css("cssText","z-index: 99 !important;     position: relative;"),n(".diana_champion_menu .search_and_social_icons .et_pb_blurb ").on("click",function(){"none"===n(".diana_champion_menu .et_pb_search").css("display")?n(".diana_champion_menu .et_pb_search").show("slow"):n(".diana_champion_menu .et_pb_search").hide("slow")}),n(".diana_champion_menu .et_pb_column_1_6 .et_pb_blurb .et_pb_blurb_description a").each(function(){0!==n(this).parent("p").length&&n(this).unwrap(),n(this).wrap("<p></p>")}),n(".full_width_menu_champion .et_pb_fullwidth_menu ").appendTo(".diana_champion_menu .menu_col "),n(".full_width_menu_champion ").remove(),n(window).width()<=767&&(n(".diana_champion_menu .logo_row .et_pb_column_1_2 .et_pb_image").appendTo(n(".diana_champion_menu .menu_row .et_pb_column_3_4 ")),n(".diana_champion_menu .menu_row .et_pb_column_3_4 .et_pb_fullwidth_menu").insertBefore(n(".diana_champion_menu .menu_row .et_pb_column_1_4 .et_pb_button_module_wrapper "))),n("body:not(.et-fb) #custom-ddp-menu .diana_champion_menu").hasClass("fixed"))){n("body:not(.et-fb) #custom-ddp-menu").addClass("fixed");var e=n("#custom-ddp-menu").height();n("#et-main-area").css("padding-top",e+"px")}},e)}(jQuery);