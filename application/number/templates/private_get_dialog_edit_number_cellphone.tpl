{% extends "dialog.tpl" %}
{% set number = component.number %}
{% block title %}Диалог редактирования сотового телефона владельца{% endblock title %}
{% block dialog %}
	<input type="text" class="dialog-input-cellphone form-control" value="{{ number.cellphone }}">
{% endblock dialog %}
{% block buttons %}
	<div class="btn btn-primary update_number_cellphone">Изменить</div>
{% endblock buttons %}
{% block script %}
	// Изменяет телефон владельца лицевого счета
	$('.update_number_cellphone').click(function(){
		$.get('update_number_cellphone',{
			id: {{ number.id }},
			cellphone: $('.dialog-input-cellphone').val()
			},function(r){
				$('.dialog').modal('hide');
				init_content(r);
			});
	});
{% endblock script %}