(function ($){
    $.fn.infinitescroll = function(options){

        var settings = $.extend({
            nextSelector : '.next',
            nav : '.pagination',
            container : '.scroll',
            loadBefore: '100',
            callback: function(){}
        }, options );

        var loading = false;

        $(window).scroll(function(){
            $(settings.nav).hide();
             
            if(loading)
                return;
            if($(document).height()-settings.loadBefore <= ($(document).scrollTop()+$(window).height())){
                var link = $(settings.nextSelector).attr('href');                 
                if(link === undefined){
                    return;
                }
                loading = true;
                var vLoader = "<div id='waitcursor' class='text-center'><i  class='fa fa-2x fa-spinner fa-spin'></i></div>";
                $(settings.container).append(vLoader); 
                $.ajax({
                    url: link ,
                    dataType : 'json',
                    method: 'get',
                    success: function(data){
                        //console.log(data);
                        var html = data.html;                        
                        var nextLink = data.link;

                        $(settings.nextSelector).attr('href', nextLink ? nextLink : null);
                        $(settings.container).append(html);
                        $("#waitcursor").remove();
                        loading = false;                         
                        settings.callback();
                    }
                });
            }
        });

        return this;
    }
}(jQuery));