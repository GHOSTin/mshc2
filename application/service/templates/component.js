$(document).ready(function(){
    // выводит содержимое услуги
    $('body').on('click', '.get_service_content', function(){
        if($(this).siblings().is('.service_content')){
            $(this).siblings('.service_content').remove();
        } else{
            $.get('get_service_content',{
                 id: get_service_id($(this))
                },function(r){
                    init_content(r);
                });
        }
    // диалог для создания услуги
    }).on('click', '.get_dialog_create_service', function(){
        $.get('get_dialog_create_service',{
            },function(r){
                init_content(r);
            });
    });
});
function get_service_id(obj){
    return obj.closest('.service').attr('service');
}