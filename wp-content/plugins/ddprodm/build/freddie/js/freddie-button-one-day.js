!function(e){var t=1e3;ua=navigator.userAgent,(ua.indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(t=5e3),e("body").hasClass("et-fb")&&(t=1e4),setTimeout(function(){e(".et_pb_button_module_wrapper .et_pb_button.freddie_button_one_day ").each(function(){var t=e(this).text();e(this).html("<span>"+t+"</span>")});var t=new TimelineLite;e(".et_pb_button_module_wrapper .et_pb_button.freddie_button_one_day ").hover(function(){t.to(e(this).find("span"),.3,{top:0,opacity:1,ease:Power0.easeNone},.3).to(e(this).find("span"),.3,{maxWidth:"500",paddingRight:21,ease:Power0.easeNone},0)},function(){t.clear(),(new TimelineLite).to(e(this).find("span"),0,{top:7,opacity:0,ease:Power0.easeNone},0).to(e(this).find("span"),.3,{maxWidth:"0px",paddingRight:0,ease:Power0.easeNone},.1)})},t)}(jQuery);