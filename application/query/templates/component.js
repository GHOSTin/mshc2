$(document).ready(function(){
	$('body').on('click', '.get_query_content', function(){
		$.get('/query/get_query_content',{
			 id: $(this).attr('query_id')
			},function(r){
				show_content(r);
			});
	});
	$('body').on('click', '.get_query_title', function(){
		$.get('/query/get_query_title',{
			 id: get_query_id($(this))
			},function(r){
				show_content(r);
			});
	});	
	$('body').on('click', '.get_query_title', function(){
		$.get('/query/get_query_title',{
			 id: get_query_id($(this))
			},function(r){
				show_content(r);
			});
	});	
	$('body').on('click', '.timeline-day', function(){
		$.get('/query/get_day',{
			 time: $(this).attr('time')
			},function(r){
				$('.queries').html(r);
			});
	});		
	$('body').on('click', '.get_search', function(){
		$.get('/query/get_search',{
			},function(r){
				$('.queries').html(r);
			});
	});
	$('body').on('click', '.get_search_result', function(){
		$.get('/query/get_search_result',{
			param: $('.search_parameters').val()
			},function(r){
				$('.queries').html(r);
			});
	});
	$('body').on('click', '.clear_filters', function(){
		$.get('/query/clear_filters',{
			},function(r){
				$('.queries').html(r);
			});
	});	
	$('.filter-content-select-status').change(function(){
		$.get('/query/set_status',{
			value: $('.filter-content-select-status :selected').val()
			},function(r){
				$('.queries').html(r);
			});
	});	
	$('body').on('click', '.get_dialog_create_query', function(){
		$.get('/query/get_dialog_create_query',{
			},function(r){
				show_content(r);
			});
	});		
});
function get_query_id(obj){
	return obj.closest('.query').attr('query_id');
}