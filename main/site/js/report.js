$(document).ready(function(){
    // возвращает список отчетов по заявкам и фильтр
    $('body').on('click', '.get_query_reports', function(){
        $.get('get_query_reports',{
            },function(r){
                init_content(r);
            });
    });
});