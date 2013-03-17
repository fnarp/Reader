$(document).ready(function(){
	jQuery('body').height(window.innerHeight+'px');
	
	/* Ajax toggle buttons. */
	jQuery('.main-content').on('click','.aj',function(){
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
	
	/**
	 * LoadView. Load this link via AJAX into the view.
	 */
	jQuery('body').on('click','.lv',function(e){
		var that = $(this)
			.addClass('pending')
			.removeClass('error');
		var ajaxTarget = $(this).attr('href');
		$.ajax({
			url : ajaxTarget,
			success : function(content){
				var sidebarpos = $('.sidebar .scroller').scrollTop();
				
				$('.main-content').replaceWith($(content).find('.main-content'));
				$('.sidebar .scroller').replaceWith($(content).find('.sidebar .scroller'));
				$('.sidebar .scroller').scrollTop(sidebarpos);
				$('body').scrollTop(0);
				
				that.removeClass('pending');
			},
			error : function(){
				window.location(ajaxTarget);
			}
		});
		e.preventDefault();
	});
	
});


jQuery(window).load(function(){
	
});
