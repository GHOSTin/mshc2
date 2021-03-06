{% extends "dialog.tpl" %}

{% block title %}Диалог редактирования почты владельца{% endblock %}

{% block dialog %}
	<input type="text" class="dialog-input-email form-control" value="{{ number.get_email() }}">
{% endblock %}

{% block buttons %}
	<div class="btn btn-primary update_number_email">Сохранить</div>
{% endblock %}

{% block script %}
	// Изменяет телефон владельца лицевого счета
	$('.update_number_email').click(function(){
		$.get('update_number_email',{
			id: {{ number.get_id() }},
			email: $('.dialog-input-email').val()
		},function(r){
			$('.dialog').modal('hide');
			init_content(r);
		});
	});
{% endblock %}