!function(e){var t=1e3;ua=navigator.userAgent,(ua.indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(t=5e3),e("body").hasClass("et-fb")&&(t=1e4),setTimeout(function(){if(0!==e(".freddie_stealin_video_content ").length&&(e(".freddie_stealin_video_content .circle_text_blurb .et_pb_blurb_description").each(function(){0!==e(this).find("p").length?e(this).find("p").addClass("circle_text"):(e(this).contents().filter(function(){return 3===this.nodeType}).wrap("<div class='circle_text'></div>"),e(this).find(".circle_text:nth-child(1)").remove());var t=e(this).find(".circle_text").text();t=t.replace(/ /g,"&nbsp;"),e(this).find(".circle_text").html(t)}),0!==e(".freddie_stealin_video_content .circle_text_blurb").length)){for(var t=new SplitText(".freddie_stealin_video_content .circle_text_blurb .et_pb_blurb_description .circle_text",{type:"chars",charsClass:"char char++",position:"absolute"}),i=e(".freddie_stealin_video_content .char"),n=0;n<i.length;n++)i[n].style.display="inline",i[n].style.width="100%",i[n].style.top=0,i[n].style.left=0;var r=new TimelineLite,c=(t.chars,e(".freddie_stealin_video_content .circle_text_blurb .et_pb_blurb_description .circle_text"));TweenLite.set(".freddie_stealin_video_content .circle_text_blurb .et_pb_blurb_description .circle_text",{perspective:400});var _=i.length,l=350/_;for(n=1;n<=_;n++)e(".freddie_stealin_video_content .circle_text_blurb .et_pb_blurb_description .char:nth-child("+n+")").css("transform","rotate("+l*n+"deg)");r.to(c,30,{rotation:"360",repeat:-1,ease:Linear.easeNone},0)}},t)}(jQuery);