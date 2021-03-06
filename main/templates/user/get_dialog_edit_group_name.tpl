{% extends "dialog.tpl" %}

{% block title %}Диалог редактирования названия группы{% endblock title %}

{% block dialog %}
	<label>Название группы</label>
	<input type="text" class="dialog-input-name form-control" value="{{ group.get_name() }}">
{% endblock dialog %}

{% block buttons %}
	<div class="btn btn-primary update_group_name">Изменить</div>
{% endblock buttons %}

{% block script %}
	// Изменяет название группы
	$('.update_group_name').click(function(){
		$.get('update_group_name',{
			id: {{ group.get_id() }},
			name: $('.dialog-input-name').val()
		},function(r){
			$('.dialog').modal('hide');
			init_content(r);
		});
	});
{% endblock script %}