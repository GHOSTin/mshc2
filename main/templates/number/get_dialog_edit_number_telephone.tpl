{% extends "dialog.tpl" %}

{% block title %}Диалог редактирования телефона владельца{% endblock %}

{% block dialog %}
	<input type="text" class="dialog-input-telephone form-control" value="{{ number.get_telephone() }}">
{% endblock %}

{% block buttons %}
	<div class="btn btn-primary update_number_telephone">Сохранить</div>
{% endblock %}

{% block script %}
	// Изменяет телефон владельца лицевого счета
	$('.update_number_telephone').click(function(){
		$.get('update_number_telephone',{
			id: {{ number.get_id() }},
			telephone: $('.dialog-input-telephone').val()
		},function(r){
			$('.dialog').modal('hide');
			init_content(r);
		});
	});
{% endblock %}