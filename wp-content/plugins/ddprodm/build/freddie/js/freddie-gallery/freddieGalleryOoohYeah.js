!function(e){var t=1e3;ua=navigator.userAgent,(ua.indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(t=1e4),e("body").hasClass("et-fb")&&(t=1e4),setTimeout(function(){0!==e(".freddie_gallery_oooh_yeah ").length&&(e(".freddie_gallery_oooh_yeah  .et_pb_gallery_item").each(function(){e(this).find("h3.et_pb_gallery_title").appendTo(e(this).find(".et_pb_gallery_image a"));var t=e(this).find("img").attr("src"),i=e(this).find("img").attr("srcset");i=(t=t.replace(/-([0-9][0-9][0-9]x[0-9][0-9])\w+/g,"")).replace(/-([0-9][0-9][0-9]x[0-9][0-9])\w+/g,""),e(this).find("img").attr("src",t),e(this).find("img").attr("srcset",i);new SplitText(e(this).find("h3.et_pb_gallery_title"),{type:"words,chars",charsClass:"char char++",position:"static"});var a=e(this).find(".et_pb_gallery_caption").text();a?e('<span class="item_link link_exist"><span class="icon_box" urlText="'+a+'" title=""></span></span>').appendTo(e(this).find("h3.et_pb_gallery_title")):e('<span class="item_link"><span class="icon_box" title=""></span></span>').appendTo(e(this).find("h3.et_pb_gallery_title"))}),e(".freddie_gallery_oooh_yeah .et_pb_gallery_item .item_link.link_exist .icon_box").on("click",function(){var t=e(this);setTimeout(function(){e(".mfp-gallery").remove(),e(".mfp-fade").remove(),window.location.href=t.attr("urlText")},10)}),e(".freddie_gallery_oooh_yeah  .et_pb_gallery_item").hover(function(){var t=new TimelineLite,i=e(this).find("h3.et_pb_gallery_title .char ").toArray();t.staggerTo(i,.5,{opacity:1,y:0,ease:Back.easeOut},.03)},function(){var t=e(this),i=new TimelineLite,a=t.find("h3.et_pb_gallery_title .char ").toArray();i.staggerTo(a,.5,{opacity:0,y:"10px",ease:Back.easeOut},.03)}))},t)}(jQuery);