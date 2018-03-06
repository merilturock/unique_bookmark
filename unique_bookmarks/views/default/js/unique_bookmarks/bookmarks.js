define(['require', 'jquery', 'elgg'], function(require, $, elgg) {
	$(document).ready(function(){

			var bookmarkAddress = $('#bookmarkAddress');
			var bookmarkSearchResult = $('#bookmarkSearchResult');
			var bookmarkFormMetas = $('#bookmarkFormMetas');
			
			bookmarkAddress.focusout(function(){
				var address = $(this).val();
				elgg.getJSON('ajax/view/unique_bookmarks/ajax_search', {
					data: {
						address: address,
					},
					success: function(results, success, xhr){
						if (results) {
							if(results.status == 1){
								bookmarkSearchResult.find('.message').html(results.message);
								bookmarkSearchResult.find('.entity').html(results.entity);
								bookmarkFormMetas.hide();
								bookmarkSearchResult.show();
							}	
						}	
					},
				});
			});

			$('#bookmarkSearchResult').find('.elgg-button').on('click', function (e){
				bookmarkFormMetas.show();
				bookmarkSearchResult.hide();
			});	
			
	});		
});

