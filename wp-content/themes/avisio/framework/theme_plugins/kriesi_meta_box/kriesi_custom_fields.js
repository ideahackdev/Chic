jQuery.noConflict();

jQuery(document).ready(function()
{	
	hijack_media_uploader();
	hijack_preview_pic();
	dropdown_superlink();
});

function hijack_preview_pic()
{
	jQuery('.kriesi_preview_pic_input').each(function()
	{
		jQuery(this).bind('change focus blur ktrigger', function()
		{	
			
			$select = '#' + jQuery(this).attr('name') + '_div';
			$value = jQuery(this).val();
			$image = '<img src ="'+$value+'" />';
						
			var $image = jQuery($select).html('').append($image).find('img');
			
			//set timeout because of safari
			window.setTimeout(function()
			{
			 	if(parseInt($image.attr('width')) < 20)
				{	
					jQuery($select).html('');
				}
			},500);
		});
	});
}




function hijack_media_uploader()
{		
		$buttons = jQuery('.k_hijack');
		$realmediabuttons = jQuery('.media-buttons a');
		
		
		window.custom_editor = false;
		
		// set a variable depending on what has been clicked, normal media uploader or kriesi hijacked uploader
		$buttons.click(function()
		{	
			window.custom_editor = jQuery(this).attr('id');			
		});
		
		$realmediabuttons.click(function()
		{
			window.custom_editor = false;
		});

		window.original_send_to_editor = window.send_to_editor;
		window.send_to_editor = function(html)
		{	
			
			if (custom_editor) 
			{	
				$img = jQuery(html).attr('src') || jQuery(html).find('img').attr('src') || jQuery(html).attr('href');
				
				jQuery('input[name='+custom_editor+']').val($img).trigger('ktrigger');
				custom_editor = false;
				window.tb_remove();
			}
			else 
			{
				window.original_send_to_editor(html);
			}
		};
}



function dropdown_superlink()
{
	jQuery('.dropdown_superlink').each(function()
	{
		var container = jQuery(this),
			superselector = container.find('.superselector'),
			subselector = container.find('.page, .post, .cat, .manually'),
			pageSelect = container.find('.page'),
			postSelect = container.find('.post'),
			catSelect = container.find('.cat'),
			manuallySelect = container.find('.manually'),
			hiddenValue = container.find('.value'),
			baseVal = superselector.val() + "$:$";
			
			
			superselector.bind("change", function()
			{	
				var newValue = superselector.val();
				
				//find all subSelects and subInputs and show only the selected one
				container.find('.page, .post, .cat, .manually').css("display","none");
				
				//set the new value for the input field
				if (newValue.length > 1) 
				{	
					container.find("."+newValue).fadeIn();
					newValue = newValue + "$:$";
				}
				
				hiddenValue.val(newValue);
				baseVal = newValue;
				
			});
			
			subselector.bind("change keyup blur", function()
			{	
			
				var current = jQuery(this),
					newValue = current.val();
				
				
				//set the new value for the input field
				
					hiddenValue.val(baseVal + newValue);
				
			});
	});
}
