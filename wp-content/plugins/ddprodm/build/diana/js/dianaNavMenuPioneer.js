!function(e){var n=1e3;e("body").hasClass("et-fb")&&(n=1e4),ua=navigator.userAgent,(ua.indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(n=5e3),setTimeout(function(){if(0!==e(".diana_pioneer_menu").length&&(e("#custom-ddp-menu").css("cssText","z-index: 99 !important;     position: relative;"),e(".diana_pioneer_menu .search_and_social_icons .et_pb_blurb ").on("click",function(){"none"===e(".diana_pioneer_menu .et_pb_search").css("display")?e(".diana_pioneer_menu .et_pb_search").show("slow"):e(".diana_pioneer_menu .et_pb_search").hide("slow")}),e(".full_width_menu_pioneer .et_pb_fullwidth_menu ").appendTo(".diana_pioneer_menu .menu_col "),e(".full_width_menu_pioneer ").remove(),e("body:not(.et-fb) #custom-ddp-menu .diana_pioneer_menu").hasClass("fixed"))){e("body:not(.et-fb) #custom-ddp-menu").addClass("fixed");var n=e("#custom-ddp-menu").height();e("#et-main-area").css("padding-top",n+"px")}},n)}(jQuery);