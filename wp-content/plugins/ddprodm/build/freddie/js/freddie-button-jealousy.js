!function(t){var e=1e3;ua=navigator.userAgent,(ua.indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(e=5e3),t("body").hasClass("et-fb")&&(e=1e4),setTimeout(function(){t(".et_pb_button_module_wrapper .et_pb_button.freddie_button_jealousy").prepend(t('<div class="left"></div><div class="center"></div><div class="right"></div>'));var e=new TimelineLite;t(".et_pb_button_module_wrapper .et_pb_button.freddie_button_jealousy").hover(function(){var i=t(this).find(".left"),n=t(this).find(".center"),d=t(this).find(".right");e.to(d,.4,{width:"100%",x:"18px"},0).to(n,.4,{width:"100%"},0).to(n,.1,{scaleX:0},.5).to(i,.1,{width:"100%",x:"18px"},.5)},function(){e.clear();var i=t(this).find(".left"),n=t(this).find(".center"),d=t(this).find(".right");(new TimelineLite).to(d,.1,{width:"50px",x:"-18px"},.3).to(n,.3,{scaleX:1},0).to(n,.1,{width:"0%"},.3).to(i,.3,{width:"50px",x:"-18px"},0)})},e)}(jQuery);