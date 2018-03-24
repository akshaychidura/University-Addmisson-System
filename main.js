$(document).ready(function(){
$("#signup").show();
$("#signin").hide();

var hide_signin=function(){$("#signin").hide('slide',{direction:'right'},500); };
var hide_signup=function(){$("#signup").hide('slide',{direction:'right'},500); };
var show_signin=function(){$("#signin").show('slide',{direction:'right'},500); };
var show_signup=function(){$("#signup").show('slide',{direction:'right'},500); };
$("#signup_click").click(function(){
	
	if($("#signin").is(':visible'))
	{
	$("#signin").hide('slide',{direction:'right'},500,function(){show_signup()});
	
	}

	else
	{
	show_signup();	
	
	}
	
	});
$("#signin_click").click(function(){
	
	if($("#signup").is(':visible'))
	{
	$("#signup").hide('slide',{direction:'right'},500,function(){show_signin()});
	
	}

	else
	{
	show_signin();	
	
	}
	
	});
	$("[data-toggle=tooltip]").tooltip();


	$("#view").click(function(){
		window.location="view.php";
	});
});