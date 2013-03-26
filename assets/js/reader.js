$(document).ready(function(){
	jQuery('body').height(window.innerHeight+'px');
	
	/* Ajax toggle buttons. */
	jQuery('body').on('click','.aj',function(){
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
	
	var pushState = function(state, title, url){
		if(typeof history.pushState != 'undefined'){
			history.pushState(state,title,url);
		} else {
			// Just a little old browser indifference.
			// Don't worry about it.
		}
	}
	
	var showState = function(url,content,modifyHistory){
		var sidebarpos = $('.sidebar .scroller').scrollTop();
		var title = $(content).find('title').text();
		var maincontent = $(content).find('.main-content');
		$('.main-content').replaceWith(maincontent);
		$('.sidebar .scroller').replaceWith($(content).find('.sidebar .scroller'));
		$('.sidebar .scroller').scrollTop(sidebarpos);
		$('body').scrollTop(0);
		
		if(modifyHistory){
			pushState(content,title,url);
		}
	}
	
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
				showState(ajaxTarget,content,true);
				that.removeClass('pending');
			},
			error : function(){
				window.location(ajaxTarget);
			}
		});
		e.preventDefault();
	});
	
	window.onpopstate = function(e){
		console.log('state popped');
		showState(document.location,e.state,false);
		console.log(e);
	};
	
	
	
});


jQuery(window).resize(function(){
	jQuery('body').height(window.innerHeight+'px');
});
