!function(t){var e=0;ua=navigator.userAgent,(ua.indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(e=5e3),t("body").hasClass("et-fb")&&(e=1e4),setTimeout(function(){if(t(".freddie_body_langauge_content .et_pb_promo ").each(function(){t('<span class="button_circle"></span>').appendTo(t(this).find(".et_pb_button_wrapper .et_pb_button")),t('<span class="button_circle hover"></span>').appendTo(t(this).find(".et_pb_button_wrapper .et_pb_button"))}),0!==t(".freddie_doing_all_right_content #circle_text .et_pb_text_inner p").length){var e=t(".freddie_doing_all_right_content #circle_text .et_pb_text_inner p").text();t(".freddie_doing_all_right_content #circle_text .et_pb_text_inner").html(e);for(var n=new SplitText(".freddie_doing_all_right_content #circle_text .et_pb_text_inner",{type:"chars",charsClass:"char char++",position:"absolute"}),_=t(".freddie_doing_all_right_content .char"),i=0;i<_.length;i++)_[i].style.display="inline",_[i].style.width="100%",_[i].style.top=0,_[i].style.left=0;var r=new TimelineLite,o=(n.chars,document.getElementById("circle_text"));TweenLite.set(".freddie_doing_all_right_content #circle_text .et_pb_text_inner",{perspective:400});var a=_.length,c=350/a;console.log(a),console.log(c);for(i=1;i<=a;i++)t(".freddie_doing_all_right_content #circle_text .et_pb_text_inner .char:nth-child("+i+")").css("transform","rotate("+c*i+"deg)");r.to(o,40,{rotation:"360",repeat:-1,ease:Linear.easeNone})}t(".freddie_cool_cat_content .et_pb_promo ").each(function(){t('<span class="button_circle"></span>').appendTo(t(this).find(".et_pb_button_wrapper .et_pb_button")),t('<span class="button_circle hover"></span>').appendTo(t(this).find(".et_pb_button_wrapper .et_pb_button"))})},e)}(jQuery);