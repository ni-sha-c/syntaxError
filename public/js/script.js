$(document).ready(function(){
	
	$('#sub').click(function(){
		event.preventDefault();
		var source = $('#source').val();
		var keystring = $('#keystring').val();		
		var data = {
			source:source,
			keystring:keystring
		}
		$.ajax({
			type:'post',
			url:"",
			data:data,
			complete:function(msg){
				console.log(msg.responseText);
			}
		})
		$('#results').empty()
		$('#results').append('<div class="result row"><h1>This is a row</h1></div>');
	});

});
