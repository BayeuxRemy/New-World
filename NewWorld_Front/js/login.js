$("#login").submit(function logFucntion(event){
	event.preventDefault();
	$.ajax({
		url:'../full-image-carousel/loginNW.php',
		data: {username: $("#username"), password: $("#password")},
		method: 'POST',x
		error : function(e){alert(JSON.stringify(e));},
		success: function(data){alert(data);}
	});
	
})