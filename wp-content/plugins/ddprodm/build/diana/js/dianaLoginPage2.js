jQuery(document).ready(function(){!function(o){o('<div class="column_1"></div><div class="column_2"></div>').appendTo(o("body.login")),o("body.login #login").appendTo("body.login .column_1");var n=o("body.login #login form label[for='user_login']").text(),l=o("body.login #login form label[for='user_pass']").text(),i=o("body.login #login form label[for='user_email']").text();o("body.login #login form label[for='user_login']").contents().filter(function(){return 1!==this.nodeType}).remove(),o("body.login #login form label[for='user_pass']").contents().filter(function(){return 1!==this.nodeType}).remove(),o("body.login #login form label[for='user_email']").contents().filter(function(){return 1!==this.nodeType}).remove(),o("body.login #login form input#user_login").attr("placeholder",n),o("body.login #login form input#user_pass").attr("placeholder",l),o("body.login #login form input#user_email").attr("placeholder",i);var e=o("body.login #login #nav").html().replace("|","");o("body.login #login #nav").html(e),o("body.login #login #nav a:last-child").addClass("lost_pasword").insertBefore(o(".body.login #login #nav a:first-child")),o('<div class="register_container"></div>').appendTo(o("body.login #login #nav")),o("body.login #login #nav a:not('.lost_pasword')").appendTo(o("body.login #login #nav .register_container"))}(jQuery)});