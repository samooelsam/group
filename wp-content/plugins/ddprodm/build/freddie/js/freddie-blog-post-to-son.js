!function(t){if(t(".freddie_to_son_post_title .et_pb_title_meta_container").length>0){let e=t(".freddie_to_son_post_title .et_pb_title_meta_container .author").html(),_=t(".freddie_to_son_post_title  .et_pb_title_meta_container .published").html();t(".freddie_to_son_post_title  .et_pb_title_meta_container > a").addClass("comments");let o=t(".freddie_to_son_post_title  .et_pb_title_meta_container > a")[0].outerHTML,i=t(".freddie_to_son_post_title  .et_pb_title_meta_container .comments-number").text();void 0!==i&&(i=i.split(" ")[0]);let n=t(".freddie_to_son_post_title  .et_pb_title_meta_container .comments-number").html();n=void 0!==n?n.replace(" comments",""):"";let r=t(".freddie_to_son_post_title  .et_pb_title_meta_container").text();r=void 0!==r?r.split(" ")[1]:"";let s="";t(".freddie_to_son_post_author .et_pb_image_wrap").length>0&&(s=t(".freddie_to_son_post_author .et_pb_image_wrap").html());let a=s+_+" "+r+" "+e+" "+n;t(".et_pb_title_meta_container").html(a),t(o).insertBefore("h1.entry-title"),t(".to_son_latest_posts article").on("click",function(e){var _=t(this).find(".entry-title a").attr("href");_?window.location.href=_:(_=t(this).find(".et_pb_image_container a").attr("href"),window.location.href=_)}),0===t(".freddie_to_son_tags").children().length&&t(".freddie_to_son_tags").parents(".et_pb_row").hide()}function e(){var e=t(".freddie_to_son_post_title .et_pb_title_featured_container").height()-451;t(".freddie_to_son_post_title .et_pb_title_featured_container").parents(".et_pb_section").css("margin-bottom",e+"px")}t(".freddie_to_son_post_comments p.comment-form-comment").insertBefore(".freddie_to_son_post_comments p.form-submit"),e(),t(window).resize(function(){t(window).width()>980?e():t(".freddie_to_son_post_title .et_pb_title_featured_container").parents(".et_pb_section").css("margin-bottom","0")})}(jQuery);