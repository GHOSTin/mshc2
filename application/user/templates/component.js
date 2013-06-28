$(document).ready(function(){
    // возвращает содержимое буквы
    $('body').on('click', '.get_user_letter', function(){
        $.get('get_user_letter',{
            letter: $(this).text()
            },function(r){
                init_content(r);
            });

    // выводит информацию об пользователе
    }).on('click', '.get_user_content', function(){
        if($(this).siblings().is('.user-content')){
            $(this).siblings('.user-content').remove();
        }else{
            $.get('get_user_content',{
                id: get_user_id($(this))
                },function(r){
                    init_content(r);
                });
        }
        
    // выводит диалог редактирования ФИО пользователя
    }).on('click', '.get_dialog_edit_fio', function(){
        $.get('get_dialog_edit_fio',{
            id: get_user_id($(this))
            },function(r){
                init_content(r);
            });
    });
});

// возвращает идентификатор пользователя
function get_user_id(obj){
    return obj.closest('.user').attr('user');
}