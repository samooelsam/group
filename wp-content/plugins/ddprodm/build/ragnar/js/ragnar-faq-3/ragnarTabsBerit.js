(function($) {
  $(document).ready(function(){
    $('.ragnar_tabs_berit').each(function(){
        $(this).find('.ragnar_tabs_berit_navigation .et_pb_module').click(function(){

            $(this).closest('.ragnar_tabs_berit_navigation').find('.et_pb_module').removeClass('active');
            $(this).addClass('active');

            var tabValue = $(this).find('.et_pb_text_inner').text().toLowerCase();
            tabValue.split(' ');
            if (tabValue.length >= 2){
                var tabValue = tabValue.replace(" ", "_");
            }
            $(this).closest('.ragnar_tabs_berit').find('.ragnar_tabs_berit_items .et_pb_module').removeClass('active');
            $(this).closest('.ragnar_tabs_berit').find('.ragnar_tabs_berit_items .'+tabValue).addClass('active');
        });
        $('.ragnar_tabs_berit').each(function(){
            var activeTab = $(this).find('.ragnar_tabs_berit_navigation .active .et_pb_text_inner').text().toLowerCase();
            $(this).find('.ragnar_tabs_berit_items').find('.'+activeTab).addClass('active');
        });

    });
  });
})( jQuery );