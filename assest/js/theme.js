jQuery(document).ready(function(){
	//theme change
	
	jQuery(".green-theme-btn").click(function(){
		jQuery("#enamHome").addClass('green-theme');
		jQuery("#enamHome").removeClass('red-theme');
		jQuery("#enamHome").removeClass('blue-theme');
		jQuery("#enamHome").removeClass('orange-theme');
	});
	jQuery(".red-theme-btn").click(function(){
		jQuery("#enamHome").addClass('red-theme');
		jQuery("#enamHome").removeClass('green-theme');
		jQuery("#enamHome").removeClass('blue-theme');
		jQuery("#enamHome").removeClass('orange-theme');
	});
	jQuery(".blue-theme-btn").click(function(){
		jQuery("#enamHome").addClass('blue-theme');
		jQuery("#enamHome").removeClass('green-theme');
		jQuery("#enamHome").removeClass('red-theme');
		jQuery("#enamHome").removeClass('orange-theme');
	});
	jQuery(".orange-theme-btn").click(function(){
		jQuery("#enamHome").addClass('orange-theme');
		jQuery("#enamHome").removeClass('green-theme');
		jQuery("#enamHome").removeClass('red-theme');
		jQuery("#enamHome").removeClass('blue-theme');
	});
	//font-size-change
	jQuery(".font-A-btn").click(function(){
		jQuery("#enamHome").addClass('font-A');
		jQuery("#enamHome").removeClass('font-A-');
		jQuery("#enamHome").removeClass('font-A-plus');
	});
	jQuery(".font-A--btn").click(function(){
		jQuery("#enamHome").addClass('font-A-');
		jQuery("#enamHome").removeClass('font-A');
		jQuery("#enamHome").removeClass('font-A-plus');
	});
	jQuery(".font-A-plus-btn").click(function(){
		jQuery("#enamHome").addClass('font-A-plus');
		jQuery("#enamHome").removeClass('font-A-');
		jQuery("#enamHome").removeClass('font-A');
	});
	/*$('#mySelect').on('change', function() {
	  var value = $(this).val();
	  alert(value);
	});*/
	
});

	
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
}
$(document).ready(function() 
{
	 var timerId = 0;
	 timerId = setInterval(function(){ 
	var blink =$("#blink").attr('class');
	if(blink=="blink")
	{
		$("#blink").addClass("blink1").removeClass("blink");
	}
	else
	{
		$("#blink").addClass("blink").removeClass("blink1");
	}
	}, 800);
	
	$("#blink").hover(function(){
	clearInterval(timerId);
	});
	
	$("#blink").mouseout(function(){
	timerId = setInterval(function(){ 
	var blink =$("#blink").attr('class');
	if(blink=="blink")
	{
		$("#blink").addClass("blink1").removeClass("blink");
	}
	else
	{
		$("#blink").addClass("blink").removeClass("blink1");
	}
	}, 800);
	});
	//var x = document.cookie;
	var x = getCookie("mycss");
	
	if(x=="")
	{
			$(".green-theme-btn").click();
	}
	else
	{
		var d = x.replace("mycss=","");
		$("."+d).click();
	}
});
		
		





 jQuery(document).keypress(function(e) {
  if (e.keyCode == 27) {
   
   jQuery(".close").click();
  }
 });
