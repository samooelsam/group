!function(e){var a=50;ua=navigator.userAgent,(ua.indexOf("MSIE ")>-1||ua.indexOf("Trident/")>-1)&&(a=1e4),e("body").hasClass("et-fb")&&(a=1e4),setTimeout(function(){if(0!==e(".ragnar_header_arne").length){for(i=1;i<=e(".ragnar_header_arne .dna_dot").length;i++)e(".ragnar_header_arne .dna_dot:nth-child("+i+")").css("cssText","animation-delay:"+.1*i+"s"),e(".ragnar_header_arne .dna_dot:nth-child("+i+")").delay(150*i).queue(function(){e(this).css("opacity",1).dequeue()})}},a)}(jQuery);