!function(t){gsap.registerPlugin(MotionPathPlugin);var n=3e3;ua=navigator.userAgent,(ua.indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(n=1e4),t("body").hasClass("et-fb")&&(n=1e4),setTimeout(function(){if(0!==t(".tina_content_throttle").length){t(".tina_content_throttle .et_pb_row.circles_row").prepend(t('<div class="animation_dot"></div>'));var n=t(".tina_content_throttle .et_pb_row.circles_row").height(),o=t(".tina_content_throttle .et_pb_row.circles_row .et_pb_column ").css("margin-right");o=parseFloat(o.replace(/-/g,"")),o=parseInt(o,10);var e=n/2-o/2,r=n/2*(n/2)-e*e;r=2*Math.sqrt(r),r=(n-r)/2;var c=n/2*(n/2)*2;c=Math.sqrt(c)-n/2;var i=(c*=c)/2;i=Math.sqrt(i);var _=t(".tina_content_throttle .et_pb_row.circles_row .animation_dot");gsap.to(_,{motionPath:{path:[{x:0,y:n/2},{x:i,y:i},{x:n/2,y:0},{x:n-i,y:i},{x:n,y:n/2},{x:n-o/2,y:n-r},{x:n-o,y:n/2},{x:n-o/2,y:r},{x:1.5*n-o,y:0},{x:2*n-1.5*o,y:r},{x:2*n-o,y:n/2},{x:2*n-1.5*o,y:n-r},{x:2*n-2*o,y:n/2},{x:2*n-1.5*o,y:r},{x:2.5*n-2*o,y:0},{x:3*n-2*o-i,y:i},{x:3*n-2*o,y:n/2},{x:3*n-2*o-i,y:n-i},{x:2.5*n-2*o,y:n},{x:2*n-1.5*o,y:n-r},{x:2*n-2*o,y:n/2},{x:2*n-1.5*o,y:r},{x:2*n-o,y:n/2},{x:2*n-1.5*o,y:n-r},{x:1.5*n-o,y:n},{x:n-o/2,y:n-r},{x:n-o,y:n/2},{x:n-o/2,y:r},{x:n,y:n/2},{x:n-o/2,y:n-r},{x:n/2,y:n},{x:i,y:n-i},{x:0,y:n/2}],curviness:.5,start:.06},ease:Linear.easeNone,duration:7,repeat:-1}),t(".tina_content_throttle .et_pb_row.circles_row .animation_dot").css("opacity",1),t('<div class="scroll_circle"></div>').appendTo(".tina_content_throttle .top_row"),t('<div class="circles_container"><div class="circles_container_inner"></div></div>').appendTo(t(".tina_content_throttle")),t(".tina_content_throttle .middle_row").appendTo(".tina_content_throttle .circles_container .circles_container_inner"),t(".tina_content_throttle .circles_row ").appendTo(".tina_content_throttle .circles_container .circles_container_inner");var s=t(".tina_content_throttle .et_pb_row.top_row").outerHeight();s=parseInt(s,10);var a=t(".tina_content_throttle .circles_container").outerHeight(),l=t(".tina_content_throttle .top_row").outerHeight();t(".tina_content_throttle").css("cssText","padding-bottom: "+a+"px; padding-top: "+l+"px");var p=t(".tina_content_throttle .circles_row ").offset().top-t(".tina_content_throttle").offset().top;t(".tina_content_throttle .scroll_circle").css("cssText","width: "+n+"px; top: "+p+"px; transform: translate(-50%, 0) scale(7);"),t(window).scroll(function(){if(t(window).scrollTop()>t(".tina_content_throttle").offset().top&&t(window).scrollTop()+t(window).height()<t(".tina_content_throttle").offset().top+t(".tina_content_throttle").outerHeight()){t(".tina_content_throttle .circles_container").css("position","fixed"),t(".tina_content_throttle .top_row").css("position","fixed"),t(".tina_content_throttle .circles_container").css("top","0px"),t(".tina_content_throttle .top_row").css("top","0px");var o=7-7/(t(".tina_content_throttle").outerHeight()-t(window).height())*(t(window).scrollTop()-t(".tina_content_throttle").offset().top);t(".tina_content_throttle .scroll_circle").css("cssText","width: "+n+"px; top: "+p+"px; transform: translate(-50%, 0) scale("+(o+.5)+");"),o+.5<=1.01?t(".tina_content_throttle .circles_container .circles_container_inner").css("opacity",1):t(".tina_content_throttle .circles_container .circles_container_inner").css("opacity",0)}else t(window).scrollTop()+t(window).height()>t(".tina_content_throttle").offset().top+t(".tina_content_throttle").outerHeight()?(t(".tina_content_throttle .circles_container").css("position","absolute"),t(".tina_content_throttle .top_row").css("position","absolute"),t(".tina_content_throttle .circles_container").css("top",t(".tina_content_throttle").outerHeight()-t(".tina_content_throttle .top_row").outerHeight()+"px"),t(".tina_content_throttle .top_row").css("top",t(".tina_content_throttle").outerHeight()-t(".tina_content_throttle .circles_container").outerHeight()+"px"),t(".tina_content_throttle .scroll_circle").css("cssText","width: "+n+"px; top: "+p+"px; transform: translate(-50%, 0) scale(0.5) ;"),t(".tina_content_throttle .circles_container .circles_container_inner").css("opacity",1)):(t(".tina_content_throttle .circles_container").css("top","0px"),t(".tina_content_throttle .top_row").css("top","0px"),t(".tina_content_throttle .circles_container").css("position","absolute"),t(".tina_content_throttle .top_row").css("position","absolute"),t(".tina_content_throttle .scroll_circle").css("cssText","width: "+n+"px; top: "+p+"px; transform: translate(-50%, 0) scale(7) ;"),t(".tina_content_throttle .circles_container .circles_container_inner").css("opacity",0))}),t(".tina_content_throttle").css("opacity",1)}},n)}(jQuery);