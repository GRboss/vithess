$( document ).ready(function() {
	$(".reportButton").click(function(){
		AAA = $(this);
		var content = $(this).attr('content');
		$.ajax({
			type: "POST",
			url: BASEURL+"index.php/reported/action/"+content
		})
		.done(function( msg ) {
			window.location.reload();
		});
	});
});
