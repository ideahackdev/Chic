jQuery.noConflict();


jQuery(document).ready(function(){

	var $target = jQuery('#description-hide')
	var $target2 = jQuery('.field-description').removeClass('hidden_field').css('display','block');
	if(($target).filter(':checked').length == 0)
	{
		$target.trigger('click');
	}
});
