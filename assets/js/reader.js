$(document).ready(function(){
	
	var articleCurrent = 0;
	var feedCurrent = 0;
	var maxRequest = 0;
	
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
	
	/**
	 * pushState, a semishim for history.pushState
	 * @param state Some state data for this uri. In our case, the AJAX response.
	 * @param The page title.
	 * @parem The URN (Bit after the url.)
	 */
	var pushState = function(state, title, urn){
		if(typeof history.pushState != 'undefined'){
			history.pushState(state,title,urn);
		} else {
			// Just a little old browser indifference.
			// Don't worry about it.
		}
	}
	
	/**
	 * showState
	 * Show a page state, commonly used when the AJAX request returns.
	 * @param urn The URN for this content.
	 * @param content string containing the AJAX response, commonly the full page. 
	 * @param modifyHistory Whether to modify the history entry (pushState) when you do.
	 */
	var showState = function(urn,content,modifyHistory){
		var sidebarpos = $('.sidebar .scroller').scrollTop();
		var title = $(content).find('title').text();
		var maincontent = $(content).find('.main-content');
		$('.main-content').replaceWith(maincontent);
		$('.sidebar .scroller').replaceWith($(content).find('.sidebar .scroller'));
		$('.sidebar .scroller').scrollTop(sidebarpos);
		
		// Reset our scroll and current article.
		$('body').scrollTop(0);
		articleCurrent = 0;
		
		if(modifyHistory){
			pushState(content,title,urn);
		}
	}

	var showArticle = function(id){
		
		var className = 'current-article';
		$('.'+className).removeClass(className);
		var article = $('.articles > li').eq(id).addClass(className);
		
		if(id == 0){
			$('body').scrollTop(0);
		} else {
			$('body').scrollTop(article.position().top);
		}
		
		markRead(article);
	}
	
	var markRead = function(ele){
		var seenEle = $('.seen',ele);
		if(seenEle.hasClass('false')){
			seenEle.click();
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
		var thisRequest = maxRequest++;
		$.ajax({
			url : ajaxTarget,
			success : function(content){
				if(thisRequest != maxRequest-1){
					// Another request has already been requested.
					return false;
				} else {
					showState(ajaxTarget,content,true);
					that.removeClass('pending');
				}
			},
			error : function(){
				window.location(ajaxTarget);
			}
		});
		e.preventDefault();
	});
	
	/**
	 * On pop state.
	 * This is fired when the back button is hit.
	 */
	window.onpopstate = function(e){
		showState(document.location,e.state,false);
	};
	
	Mousetrap.bind(['j','k'],function(e,key){
		
		markRead($('.articles > li').eq(articleCurrent));
		
		
		if(key == 'j'){
			articleCurrent++;
		} else {
			articleCurrent--;
		}
		
		if(articleCurrent < 0) {
			articleCurrent = 0;
		}
		
		if(articleCurrent >= $('.articles > li').length) {
			articleCurrent--;
		}
		
		showArticle(articleCurrent);
		
	});
	
	
	
});


jQuery(window).resize(function(){
	jQuery('body').height(window.innerHeight+'px');
});
