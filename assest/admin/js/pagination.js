$(document).ready(function(){
	var baseUrl = $('#base_url').val();
	
	$(document).on('change','#event_page_counter',function(){
		event_page();
	});
});

function event_page(){
	var group = 'admin';
	var page_count = $('#event_page_counter').val();
	var is_home = $('#event_is_home') .val();
	var is_active = $('#event_is_active').val();
	var search_text = $('#event_search').val();
	var ulanguage = 1;
	$.ajax({
        type: 'POST',
        url: baseUrl+'admin/Event_ctrl/get_events_ajax',
        dataType: "json",
        data: {
        	'page_count' : page_count,
        	'is_home' : is_home,
        	'is_active' : is_active,
        	'search_text' : search_text
        },
        beforeSend: function(){
        	$('#welcome').html('<img style="width:40px;" alt="" src="'+ baseUrl +'/assest/images/gif-load.gif" />');
        },
        complete: function(){},
        success:function (response){
        	console.log(response);
        	var x = '';
        	x = x + '<table class="table events-edit-bg">'+
						'<tr>'+
							'<th>Image</th>'+
							'<th>Event</th>'+
							'<th>Category</th>';
							if(group != 'subadmin'){
								x = x + '<th>Sort</th>'+
										'<th>Publish</th>'+
										'<th>Show Homepage</th>';
							}
							x = x + '<th>Action</th>'+
						'</tr>'+
						'<tbody>';
						if(response.data.length > 0){
							$.each(response.data,function(key,value){
							if(value.lang_id == 1) {
								var find = 0;
								$.each(response.data,function(k,v){
									if(v.event_id == v.event_id && v.lang_id == ulanguage){
									find = 1;
									}
								});	
							if(!find){
								x = x + '<tr class="find">';
							}
							else{ 
								x = x + '<tr class="">';
							}						
							x = x + '<td><img width="90" src="'+ baseUrl +'"Event_gallary/".'+ value.event_image +'"></td>'+
								'<td >'+ value.title; +'</td>'+
								'<td>'+ value.event_category +'</td>';
							if(group != 'subadmin'){
								x = x + '<td>'+ value.sort +'</td>'+
										'<td>';
									if(value.publish){ 
										x = x +'<input class="event_published" data-event_id="'+ value.event_id +'" type="checkbox" checked />';										
									} else {
										x = x +'<input class="event_published" data-event_id="'+ value.event_id +'" type="checkbox" />';
									}
								x = x +'</td>'+
								'<td>';
							    if(value.is_home){
										x = x + '<input class="is_home" data-event_id="'+ value.event_id +'" type="checkbox" checked />';										
								} else { 
										x = x + '<input class="is_home" data-event_id="'+ value.event_id +'" type="checkbox" />';
								}
								x = x +'</td>';
							} 
							x =x + '<td>';
							if(group == 'subadmin'){
								x = x +'<a class="btn btn-info btn-flat event_tranlate" data-event_id="'+ value.event_id +'"><i class="fa fa-language"></i></a>';
							} else {
								x = x +'<a class="btn btn-info btn-flat event_edit" data-event_id="'+ value.event_id +'"><i class="fa fa-pencil"></i></a>'+ 
						    	   '<a class="btn btn-info btn-flat event_delete" data-event_id="'+ value.event_id +'"><i class="fa fa-trash"></i></a>';
							}
							x =x + '</td>'+
						'</tr>';
						}
					});
					} 
				x = x +'</tbody>'+
			'</table>';
			$('#welcome').html(x);
        }
	});
}


