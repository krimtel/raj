load_first();
var local_data;
var total_apmc = 0;
var total_mol = 0;
var flag = 1;
var page_counter = 0;
c = 0;
function load_first(){
$.ajax({
		type : 'POST',
		url : 'http://www.enam.gov.in/NamWebSrv/rest/liveBidding/stateWise',
		dataType : 'json',
		data : {
			'orgId' : 1,
			'language' : 'en'
		},
		success : function (response){
			local_data = response;
			$.each(response.listActiveState, function(key,value){ 
				var stateName = value.stateName.toUpperCase().split(' ').join('_');
				
				if(value.activeCount != '0'){
					//debugger;
					//$('#'+ stateName+'').css({"background-image":"url(images/state-map/"+ stateName +"_GREEN.png)","background-repeat":"no-repeat"});
					$('#'+ stateName+'').find('span').css({"background-image":"url(images/home/green-lamp.png)","background-repeat":"no-repeat"});
				}
				else{
					//debugger;
					//$('#'+ stateName+'').css({"background-image":"url(images/state-map/"+ stateName +"_RED.png)","background-repeat":"no-repeat"});
					$('#'+ stateName+'').find('span').css({"background-image":"url(images/home/red-lamp.png)","background-repeat":"no-repeat"});
				}
			total_apmc = parseInt(parseInt(total_apmc) + parseInt(value.oprCount));
			total_mol = parseInt(parseInt(total_mol) + parseInt(value.activeCount));
			});
		}
	});
}