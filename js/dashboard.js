$( document ).ready(function() {
	$(".actionButton").click(function(){
		AAA = $(this);
		var content = $(this).attr('content');
		$.ajax({
			type: "POST",
			url: BASEURL+"index.php/areas/action/"+content
		})
		.done(function( msg ) {
			window.location.reload();
		});
	});
});
