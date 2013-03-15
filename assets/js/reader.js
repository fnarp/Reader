$(document).ready(function(){
	$('body').height(window.innerHeight+'px');
	
	/* Ajax toggle buttons. */
	$('.aj').click(function(){
		var that = $(this)
			.addClass('pending')
			.removeClass('error');
		$.ajax({
			url : $(this).attr('href'),
			success : function(){
				that
					.toggleClass('true')
					.toggleClass('false')
					.removeClass('pending');
			},
			error : function(){
				that
					.removeClass('pending')
					.addClass('error');
			}
		});
		
		return false;
	});
	
});
