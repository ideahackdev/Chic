

jQuery.noConflict();

jQuery(document).ready(function(){


// -------------------------------------------------------------------------------------------
// START EDITING HERE
// -------------------------------------------------------------------------------------------
	
	var portfolioSorter = jQuery('.portfolio'); // selects the portfolio container
	portfolioSorter.kriesi_portfolio_sort({items:'.sortable'});	// activates portfolio sorting
	
	//on sites without portfolio activate basic image preloading
	if(portfolioSorter.length == 0) jQuery('.preloading').aviaSlider_preloadhelper({delay:100});


	// activates the lightbox page
	my_lightbox("a[rel^='prettyPhoto'], a[rel^='lightbox']",true);
	
	// font replacement, remove this line if you want to use a different font defined in css, 
	// or if the current font doesnt support some of your language specific characters
	
	k_menu(); // controls the dropdown menu

	k_smoothscroll(); //smooth scrolling
	

	// aviaslider variable preparation
	var newTransitionOrder = [];
	if(slideShowArray['transition_direction_final'] != undefined)
	{
		newTransitionOrder = slideShowArray['transition_direction_final'].split(", ");
	}
	
	if(newTransitionOrder[0] == "" || newTransitionOrder[0] == undefined)
	{ 
		newTransitionOrder = ['diagonaltop', 'diagonalbottom','topleft', 'bottomright', 'random'];
	}
	
	
	// aviaslider initialisation
	jQuery(".aviaslider").aviaSlider({
			animationSpeed:parseInt(slideShowArray['slide_transition']),		// animation duration
			autorotation: parseInt(slideShowArray['slide_autorotate']),		// autorotation true or false?
			autorotationSpeed:parseInt(slideShowArray['slide_duration']),		// duration between autorotation switch in Seconds
			transition: slideShowArray['box_transition'],
			blockSize: {height: slideShowArray['box_height'], width:slideShowArray['box_width']},	//heigth and width of the blocks'
			betweenBlockDelay:parseInt(slideShowArray['box_transition_delay']),// delay between each block change
			transitionOrder: newTransitionOrder,
			showText: true,											// wether description text should be shown or not 
			display: 'all', 										// showing up blocks: random, topleft, bottomright, diagonaltop, diagonalbottom, all
			switchMovement: false,									// if display is set "topleft" it will switch to "br" every 2nd transition
			slideControlls: 'items',								// which controlls should the be displayed for the user: none, items
			slides: '.featured',									// wich element inside the container should serve as slide
			captionReplacement:'.feature_excerpt'
			});
	
	//adds the functionallity of external controlls, in our case the small thumbnail images
	jQuery('.slideThumWrap').aviaFeatureThumbs();	
	jQuery('#wrapper_featured_area .slidecontrolls').aviaSlider_externalControlls();
	
	
var templateUrl = jQuery("meta[name=temp_url]").attr('content'),
	formSendPath = templateUrl + '/send.php';


	jQuery('.ajax_form').kriesi_ajax_form({sendPath:formSendPath});	// activates contact form
	jQuery('input:text').kriesi_empty_input({sendPath:formSendPath});	// comment form improvement
	

	/*Embedded Videos*/
	var url = jQuery("meta[name=temp_url]").attr('content');
	flowplayer(".videoplayer", {src: templateUrl + "/flashplayer/flowplayer-3.1.5.swf", wmode: "transparent", cachebusting: jQuery.browser.msie}, { // "videoplayer" is the class the player gets applied to
		clip: {  
	        autoPlay: true,
	        autoBuffering: true 
	    },
	   
		plugins: 
		{ 
			controls: 
			{ 
				// display properties 
		        backgroundColor: '#333333', 
		        backgroundGradient: 'none', 
		        sliderColor: '#111111',
		        progressColor: '#ffffff', 
  				bufferColor: '#aaaaaa', 
		 
		        // controlbar-specific configuration 
		        fontColor: '#ffffff',
		        timeFontColor: '#333333', 
		        autoHide: 'always' 
	        }
	        
	        ,controls: null //remove this line if you want to show controls
		}
	});
	
	//activates the toggle shortcode js
	jQuery('#top').k_toggle();
	jQuery('.tabcontainer').k_tabs();
	jQuery('.frontpagetabs').k_tabs({cloneheading:true, heading:'.fptab', content:'.fptab_content', append:'fp'});
	
	
	
	k_pixelperfect();
	
	
	
// -------------------------------------------------------------------------------------------
// END EDITING HERE
// -------------------------------------------------------------------------------------------		
});


(function($)
{
	$.fn.aviaFeatureThumbs = function(options) 
	{
		var defaults = 
		{
			titleWrap: '.slideThumbTitle',
			border: '.fancy'
			
		};
		
		var options = $.extend(defaults, options);
	
		return this.each(function()
		{
		
		//border behaviour
			var item = $(this),
				title = $(options.titleWrap, item), 
				border = $(options.border, item),
				theWidth = item.width(),
				theHeight = item.height();
				
			
			item.bind('mouseenter', function()
			{
				border.stop().animate({top:"-6px",left:"-6px",height:theHeight+12,width:theWidth+12},300);
				showTitle();
			});
			
			item.bind('mouseleave', function()
			{
				border.stop().animate({top:"0px", left:"0px",height:theHeight-6,width:theWidth-6},200);
				hideTitle();
			});
		
			
		//tooltip behaviour
		
			title.insertAfter(item);
			
			function showTitle()
			{
				title.stop().css({display:'block', opacity:0}).animate({opacity:0.85, bottom: "70px"});
			}
			
			function hideTitle()
			{
				title.stop().animate({opacity:0, bottom: "80px"}, function()
				{
					title.css({display:'none'});
				});
			}
				
		});
	}
})(jQuery);



// -------------------------------------------------------------------------------------------
// portfolio sorting 
// -------------------------------------------------------------------------------------------

(function($)
{
	$.fn.kriesi_portfolio_sort = function(options) 
	{
		var defaults = 
		{
			items: '.items',
			linkContainer:'#js_sort_items',
			filterItems: '.sort_by_cat',
			sortItems:'sort_by_val'
			
		};
		
		var options = $.extend(defaults, options);
	
		return this.each(function()
		{
			var container = $(this),
				linkContainer = $(options.linkContainer),
				links = linkContainer.find('a'),
				items = container.find(options.items),
				itemLinks = items.find('a'),
				itemPadding = parseInt(items.css('paddingBottom')),
				itemSelection = '',
				columns = 0,
				coordinates = new Array(),
				animationArray = new Array(),
				columnPlus = new Array();
						
			container.methods = {
			
				preloadingDone: function()
				{		
									
					if(linkContainer.length > 0 && !($.browser.msie && $.browser.version < 7))
					{	
						//set container height, get all items and save coordinates
						container.css('height',container.height());
						items.each(function()
						{ 
							var item = $(this),
								itemPos = item.position();

							coordinates.push(itemPos); 
						})
						.each(function(i)
						{ 
							var item = $(this);
							item.css({position:'absolute', top: coordinates[i].top+'px', left: coordinates[i].left+'px'});
						});					
						
						//set columns
						for(i = 0; i < coordinates.length; i++)
						{	
							if(coordinates[i].top == coordinates[0].top) columns ++;
						}
						
						//show controlls
						if($.browser.msie)
						{
							linkContainer.css({display:'none', visibility:"visible"}).slideDown();	
						}
						else
						{
							linkContainer.css({opacity:0, visibility:"visible"}).animate({opacity:1});
						}
						
						// bind action to click events
						container.methods.bindfunctions();
						
					}
				},
				
				bindfunctions: function()
				{	
					links.click(function()
					{	
						var clickedElement = $(this),
							elementFilter = this.id;
							
							animationArray = new Array();
							
						//apply active state
						clickedElement.parent().find('.active_sort').removeClass('active_sort');
						this.className += ' active_sort';
						
						// if we need to filter items
						if(clickedElement.parent().is(options.filterItems))
						{
							var arrayIndex = 0,
								columnIndex = 0;
								
							columnPlus = new Array();
							
							items.each(function(i)
							{
								var item = $(this);
								
								if(item.is('.'+elementFilter))
								{	
									animationArray.push(
									{
                                        element: item, 
                                        animation: 
                                        { 
                                             opacity: 1,
                                             top: coordinates[arrayIndex].top,
                                             left: coordinates[arrayIndex].left
                                        },
                                        height: item.height()
                                    });

                                    
                                    if(columnTop < coordinates[arrayIndex].top)  columnTop = coordinates[arrayIndex].top;
                                    
                                    columnIndex++;
                                    arrayIndex++;
								}
								else
								{
									animationArray.push(
                                    {
                                        element: item, 
                                        animation: 
                                        { 
                                             opacity: 0
                                        },
                                        callback: true
                                    });
								}
								
								if(items.length == i+1 || columnIndex == columns)
                                {	
 									var columnTop = 0;
                                	
                                	for (x = 0; x < columnIndex; x++)
                                	{	
                                		if(animationArray[i-x].height)
                                		{
                                			if(columnTop < animationArray[i-x].height) columnTop = animationArray[i-x].height;
                                		}
                                		else
                                		{
                                			columnIndex++;
                                		}
                                		
                                	}
                                	columnPlus.push(columnTop);
                                	columnIndex = 0;
                                }		
                                							
								if(i+1 == items.length) container.methods.startAnimation();
							});
												
						}
						else // if we need to sort items first
						{	
							var sortitems = items.get(),
								reversed = false;
							
							if(clickedElement.is('.reversed')) reversed = true;
							
							sortitems.sort(function(a, b) 
							{
								var compA = $(a).find('.'+elementFilter).text().toUpperCase();
								var compB = $(b).find('.'+elementFilter).text().toUpperCase();
								if (reversed) 
								{
									return (compA < compB) ? 1 : (compA > compB) ? -1 : 0;				
								} 
								else 
								{		
									return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;	
								}
							});
							
							items = $(sortitems);
							$(options.filterItems).find('.active_sort').trigger('click');
							
						}
						
						return false;
					});
				},
				
				startAnimation: function()
				{	
					var heightmodifier = coordinates[0].top,
						visibleElement = 0,
						currentCol = 0;
					
					for (i = 0; i < animationArray.length; i++) 
					{	
						if(animationArray[i].animation.top)
						{
							if(visibleElement % columns == 0 && visibleElement != 0)
							{
								heightmodifier += columnPlus[currentCol] + itemPadding;
								currentCol ++;
							}
							visibleElement++;
						}
						
						animationArray[i].animation.top = heightmodifier;
             			animationArray[i].element.css('display','block').animate(animationArray[i].animation, 800, "easeInOutQuint", (function(i)
             			{
							return function() 
							{
								if(animationArray[i].callback == true)
	             				{	
	             					animationArray[i].element.css({display:"none"});	             					
	             				}
							}
             			})(i));
            		}
            		
            		
            		var newContainerHeight = coordinates[0].top;
            						
					for(z = 0; z < columnPlus.length; z++ )
					{
						newContainerHeight += columnPlus[z] + itemPadding;
					}
											
					container.animate({height:newContainerHeight}, 800, "easeInOutQuint");	
				}
				
			}
			
			
			
			container.aviaSlider_preloadhelper({delay:100, callback:container.methods.preloadingDone});
			
		});
	}
})(jQuery);	



// -------------------------------------------------------------------------------------------
// input field improvements
// -------------------------------------------------------------------------------------------

(function($)
{
	$.fn.kriesi_empty_input = function(options) 
	{
		return this.each(function()
		{
			var currentField = $(this);
			currentField.methods = 
			{
				startingValue:  currentField.val(),
				
				resetValue: function()
				{	
					var currentValue = currentField.val();
					if(currentField.methods.startingValue == currentValue) currentField.val('');
				},
				
				restoreValue: function()
				{	
					var currentValue = currentField.val();
					if(currentValue == '') currentField.val(currentField.methods.startingValue);
				}
			};
			
			currentField.bind('focus',currentField.methods.resetValue);
			currentField.bind('blur',currentField.methods.restoreValue);
		});
	}
})(jQuery);	



function k_smoothscroll()
{
	jQuery('a[href*=#]').click(function() {
		
	   var newHash=this.hash;
	   
	   if(newHash != '' && newHash != '#' )
	   {
		   var target=jQuery(this.hash).offset().top,
			   oldLocation=window.location.href.replace(window.location.hash, ''),
			   newLocation=this,
			   duration=800,
			   easing='easeOutQuint';
		
			
			
			
		   // make sure it's the same location      
		   if(oldLocation+newHash==newLocation)
		   {
		      // animate to target and set the hash to the window.location after the animation
		      jQuery('html:not(:animated),body:not(:animated)').animate({ scrollTop: target }, duration, easing, function() {
		
		         // add new hash to the browser location
		         window.location.href=newLocation;
		      });
		
		      // cancel default click action
		      return false;
		   }
		
		}
	
	});
}


function k_menu()
{
	// k_menu controlls the dropdown menus and improves them with javascript
	
	jQuery(".nav a").removeAttr('title');
	jQuery(" .nav ul ").css({display: "none"}); // Opera Fix

	
	//smooth drop downs
	jQuery(".nav li").each(function()
	{	
		
		var $sublist = jQuery(this).find('ul:first');
		
		jQuery(this).hover(function()
		{	
			$sublist.stop().css({overflow:"hidden", height:"auto", display:"none", paddingTop:30}).slideDown(400, function()
			{
				jQuery(this).css({overflow:"visible", height:"auto"});
			});	
		},
		function()
		{	
			$sublist.stop().slideUp(400, function()
			{	
				jQuery(this).css({overflow:"hidden", display:"none"});
			});
		});	
	});
}



//equalHeights by james padolsey
jQuery.fn.equalHeights = function() {
    return this.height(Math.max.apply(null,
        this.map(function() {
           return jQuery(this).height()
        }).get()
    ));
};



function my_lightbox($elements, autolink)
{	
	var theme_selected = 'light_square';
	
	if(autolink)
	{
		jQuery('a[href$=jpg], a[href$=png], a[href$=gif], a[href$=jpeg], a[href$=".mov"] , a[href$=".swf"] , a[href*="vimeo.com"] , a[href*="youtube.com"]').each(function()
		{
			if(!jQuery(this).attr('rel') != undefined && !jQuery(this).attr('rel') != '' && !jQuery(this).hasClass('noLightbox'))
			{
				jQuery(this).attr('rel','lightbox[auto_group]')
			}
		});
	}
	
	jQuery($elements).prettyPhoto({
			"theme": theme_selected /* light_rounded / dark_rounded / light_square / dark_square */																	});
	
	jQuery($elements).each(function()
	{	
		var $image = jQuery(this).contents("img");
		$newclass = 'lightbox_video';
		
		if(jQuery(this).attr('href').match(/(jpg|gif|jpeg|png|tif)/)) $newclass = 'lightbox_image';
			
		if ($image.length > 0)
		{	
			if(jQuery.browser.msie &&  jQuery.browser.version < 7) jQuery(this).addClass('ie6_lightbox');
			
			var $bg = jQuery("<span class='"+$newclass+" '></span>").appendTo(jQuery(this));
			
			jQuery(this).bind('mouseenter', function()
			{
				if ($image.css('opacity') >= 0.1) { jQuery(this).removeClass('preloading'); }
				
				var $height = $image.height(),
					$width = $image.width(),
					$pos =  $image.position(),
					$paddingX = parseInt($image.css('paddingTop')) + parseInt($image.css('paddingBottom')),
					$paddingY = parseInt($image.css('paddingLeft')) + parseInt($image.css('paddingRight'));					
				
				$bg.css({height:$height + $paddingY, width:$width + $paddingX, top:$pos.top, left:$pos.left});
			});
		}
	});	
	
	jQuery($elements).contents("img").hover(function()
	{
		jQuery(this).stop().animate({opacity:0.2},400);
	},
	function()
	{
		jQuery(this).stop().animate({opacity:1},400);
	});
}


(function($)
{
	$.fn.kriesi_ajax_form = function(options) 
	{
		var defaults = 
		{
			sendPath: 'send.php',
			responseContainer: '.ajaxresponse'
		};
		
		var options = $.extend(defaults, options);
		
		return this.each(function()
		{
			var form = $(this),
				send = 
				{
					formElements: form.find('textarea, select, input:text, input[type=hidden]'),
					validationError:false,
					button : form.find('input:submit'),
					datastring : ''
				};
			
			send.button.bind('click', checkElements);
			
			function send_ajax_form()
			{
				send.button.fadeOut(300);	
									
				$.ajax({
					type: "POST",
					url: options.sendPath,
					data:send.datastring,
					success: function(response)
					{	
						
						var message =  $("<div'></div>").addClass(options.responseContainer)
														.css('display','none')
														.insertBefore(form)
														.html(response); 
														
						form.slideUp(400, function(){message.slideDown(400), send.formElements.val('');});
						
					}
				});
				
			}
			
			function checkElements()
			{	
				// reset validation var and send data
				send.validationError = false;
				send.datastring = 'ajax=true';
				
				send.formElements.each(function(i)
				{
					var currentElement = $(this),
						surroundingElement = currentElement.parent(),
						value = currentElement.val(),
						name = currentElement.attr('name'),
					 	classes = currentElement.attr('class'),
					 	nomatch = true;
					 	
					 	send.datastring  += "&" + name + "=" +encodeURIComponent(value);
					 	
					 	if(classes.match(/is_empty/))
						{
							if(value == '')
							{
								surroundingElement.attr("class","").addClass("error");
								send.validationError = true;
							}
							else
							{
								surroundingElement.attr("class","").addClass("valid");
							}
							nomatch = false;
						}
						
						if(classes.match(/is_email/))
						{
							if(!value.match(/^\w[\w|\.|\-]+@\w[\w|\.|\-]+\.[a-zA-Z]{2,4}$/))
							{
								surroundingElement.attr("class","").addClass("error");
								send.validationError = true;
							}
							else
							{
								surroundingElement.attr("class","").addClass("valid");
							}	
							nomatch = false;
						}
						
						if(nomatch && value != '')
						{
							surroundingElement.attr("class","").addClass("valid");
						}
				});
				
				if(send.validationError == false)
				{
					send_ajax_form();
				}
				return false;
			}
		});
	}
})(jQuery);






/*
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
*/

// t: current time, b: begInnIng value, c: change In value, d: duration
jQuery.easing['jswing'] = jQuery.easing['swing'];

jQuery.extend( jQuery.easing,
{
	def: 'easeOutQuad',
	swing: function (x, t, b, c, d) {
		//alert(jQuery.easing.default);
		return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
	},
	easeInQuad: function (x, t, b, c, d) {
		return c*(t/=d)*t + b;
	},
	easeOutQuad: function (x, t, b, c, d) {
		return -c *(t/=d)*(t-2) + b;
	},
	easeInOutQuad: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t + b;
		return -c/2 * ((--t)*(t-2) - 1) + b;
	},
	easeInCubic: function (x, t, b, c, d) {
		return c*(t/=d)*t*t + b;
	},
	easeOutCubic: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t + 1) + b;
	},
	easeInOutCubic: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t + b;
		return c/2*((t-=2)*t*t + 2) + b;
	},
	easeInQuart: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t + b;
	},
	easeOutQuart: function (x, t, b, c, d) {
		return -c * ((t=t/d-1)*t*t*t - 1) + b;
	},
	easeInOutQuart: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
		return -c/2 * ((t-=2)*t*t*t - 2) + b;
	},
	easeInQuint: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t*t + b;
	},
	easeOutQuint: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t*t*t + 1) + b;
	},
	easeInOutQuint: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
		return c/2*((t-=2)*t*t*t*t + 2) + b;
	},
	easeInSine: function (x, t, b, c, d) {
		return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
	},
	easeOutSine: function (x, t, b, c, d) {
		return c * Math.sin(t/d * (Math.PI/2)) + b;
	},
	easeInOutSine: function (x, t, b, c, d) {
		return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
	},
	easeInExpo: function (x, t, b, c, d) {
		return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
	},
	easeOutExpo: function (x, t, b, c, d) {
		return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
	},
	easeInOutExpo: function (x, t, b, c, d) {
		if (t==0) return b;
		if (t==d) return b+c;
		if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
		return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
	},
	easeInCirc: function (x, t, b, c, d) {
		return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
	},
	easeOutCirc: function (x, t, b, c, d) {
		return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
	},
	easeInOutCirc: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
		return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
	},
	easeInElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
	},
	easeOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
	},
	easeInOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
		return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
	},
	easeInBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*(t/=d)*t*((s+1)*t - s) + b;
	},
	easeOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
	},
	easeInOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158; 
		if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
		return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
	},
	easeInBounce: function (x, t, b, c, d) {
		return c - jQuery.easing.easeOutBounce (x, d-t, 0, c, d) + b;
	},
	easeOutBounce: function (x, t, b, c, d) {
		if ((t/=d) < (1/2.75)) {
			return c*(7.5625*t*t) + b;
		} else if (t < (2/2.75)) {
			return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
		} else if (t < (2.5/2.75)) {
			return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
		} else {
			return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
		}
	},
	easeInOutBounce: function (x, t, b, c, d) {
		if (t < d/2) return jQuery.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;
		return jQuery.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;
	}
});

function k_pixelperfect()
{
	if(jQuery.browser.opera) // opera somewhat sucks when something is alligned with pos absolute and bottom
	{	
	}

	var commentform = jQuery('#commentform');
	commentform.find('#submit').bind('mousedown', function()
	{
		var website = commentform.find('#url');
		if (website.val() == 'Website' || website.val() == 'http://Website') { website.val("");}
		
	});


}



(function($)
{
	$.fn.k_toggle = function(options) 
	{
		var defaults = 
		{
			heading: '.toggler',
			content:'.toggle'
			
		};
		
		var options = $.extend(defaults, options);
	
		return this.each(function()
		{
			var container = $(this),
				heading   = $(options.heading, container),
				allContent = $(options.content, container);
				
								
			heading.bind('click', function()
			{
				var thisheading =  $(this);
					content = thisheading.next(options.content, container);
				

				if(content.is('.open'))
				{
					content.removeClass('open').slideUp(500);
					thisheading.removeClass('activeTitle');
				}
				else
				{
					if(thisheading.is('.closeAll'))
					{
						allContent.removeClass('open').slideUp(500);
						heading.removeClass('activeTitle');
					}
					content.addClass('open').slideDown(500);
					thisheading.addClass('activeTitle');
				}
			});
		});
	}
})(jQuery); 




(function($)
{
	$.fn.k_tabs= function(options) 
	{
		var defaults = 
		{
			heading: '.tab',
			content:'.tab_content',
			cloneheading:false,
			append:''
		};
		
		var options = $.extend(defaults, options);
	
		return this.each(function()
		{
			var container = $(this),
				tabs = $(options.heading, container),
				content = $(options.content, container);
			
			// sort tabs
			
			if(tabs.length < 2) return;
			
			if(options.cloneheading)
			{	
				var newTabs = '',
					first = options.append+'active_tab';
				
				tabs.removeClass(options.heading).each(function(i)
				{	
					var currentTab = $(this);
					currentTab.prependTo(content[i]);
					if(i != 0) first = '';
					newTabs += "<span class='transformed_tab tab "+first+"'>"+currentTab.text()+"</span>";
				});
				
				tabs = $(newTabs).prependTo(container);
			}
			else
			{
				tabs.prependTo(container);
			}
			$('p:empty').remove();
			
				
			tabs.each(function(i)
			{
				$(this).bind('click', function()
				{
					var tab = $(this);
					
					if(!tab.is('.'+options.append+'active_tab'))
					{
						$('.'+options.append+'active_tab', container).removeClass(options.append+'active_tab');
						$('.'+options.append+'active_tab_content', container).removeClass(options.append+'active_tab_content');
						
						tab.addClass(options.append+'active_tab');
						content.filter(':eq('+i+')').addClass(options.append+'active_tab_content');
					}
					
					return false;
				});
			});
		
		});
	}
})(jQuery); 



/**
 * AviaSlider - A jQuery image slider
 * (c) Copyright Christian "Kriesi" Budschedl
 * http://www.kriesi.at
 * http://www.twitter.com/kriesi/
 * For sale on ThemeForest.net
 */

/* this prevents dom flickering, needs to be outside of dom.ready event: */
document.documentElement.className += ' js_active ';
/*end dom flickering =) */


(function($)
{
	$.fn.aviaSlider= function(variables) 
	{
		var defaults = 
		{
			slides: 'li',				// wich element inside the container should serve as slide
			animationSpeed: 900,		// animation duration
			autorotation: true,			// autorotation true or false?
			autorotationSpeed:3,		// duration between autorotation switch in Seconds
			appendControlls: '',		// element to apply controlls to
			slideControlls: 'items',	// controlls, yes or no?
			blockSize: {height: 'full', width:'full'},
			betweenBlockDelay:60,
			display: 'topleft',
			switchMovement: false,
			showText: true,	
			captionReplacement: false,		//if this is set the element will be used for caption instead of the alt tag
			transition: 'fade',			//slide, fade or drop	
			backgroundOpacity:0.8,		// opacity for background
			transitionOrder: ['diagonaltop', 'diagonalbottom','topleft', 'bottomright', 'random']
		};
		
		var options = $.extend(defaults, variables);
		 
		return this.each(function()
		{
			var slideWrapper = $(this),									//wrapper element
				slides = slideWrapper.find(options.slides),				//single slide container
				slideImages	= slides.find('img'),						//slide image within container
				slideCount 	=	slides.length,							//number of slides
				slideWidth =	slides.width(),							//width of slidecontainer
				slideHeight= slides.height(),							//height of slidecontainer
				blockNumber = 0,										//how many blocks do we need
				currentSlideNumber = 0,									//which slide is currently shown
				reverseSwitch = false,									//var to set the starting point of the transition
				currentTransition = 0,									//var to set which transition to display when rotating with 'all'
				current_class = 'active_item',							//currently active controller item
				controlls = '',											//string that will contain controll items to append
				skipSwitch = true,										//var to check if performing transition is allowed
				interval ='',
				blockSelection ='',
				blockSelectionJQ ='',
				blockOrder = [];										
			
			//check if either width or height should be full container width			
			if (options.blockSize.height == 'full') { options.blockSize.height = slideHeight; } else { options.blockSize.height = parseInt(options.blockSize.height)}
			if (options.blockSize.width == 'full') { options.blockSize.width = slideWidth; } else { options.blockSize.width = parseInt(options.blockSize.width)}
			
			//slider methods that controll the whole behaviour of the slideshow	
			slideWrapper.methods = {
			
				//initialize slider and create the block with the size set in the default/options object
				init: function()
				{	
					var posX = 0,
						posY = 0,
						generateBlocks = true,
						bgOffset = '';
					
					// make sure to display the first image in the list at the top
					slides.filter(':first').css({'z-index':'5',display:'block'});
						
					// start generating the blocks and add them until the whole image area
					// is filled. Depending on the options that can be only one div or quite many ;)
					while(generateBlocks)
					{
						blockNumber ++;
						bgOffset = "-"+posX +"px -"+posY+"px";
						
						$('<div class="kBlock"></div>').appendTo(slideWrapper).css({	
								zIndex:20, 
								position:'absolute',
								display:'none',
								left:posX,
								top:posY,
								height:options.blockSize.height,
								width:options.blockSize.width,
								backgroundPosition:bgOffset
							});
				
						
						posX += options.blockSize.width;
						
						if(posX >= slideWidth)
						{
							posX = 0;
							posY += options.blockSize.height;
						}
						
						if(posY >= slideHeight)
						{	
							//end adding Blocks
							generateBlocks = false;
						}
					}
					
					//setup directions
					blockSelection = slideWrapper.find('.kBlock');
					blockOrder['topleft'] = blockSelection;
					blockOrder['bottomright'] = $(blockSelection.get().reverse());
					blockOrder['diagonaltop'] = slideWrapper.methods.kcubit(blockSelection);
					blockOrder['diagonalbottom'] = slideWrapper.methods.kcubit(blockOrder['bottomright']);
					blockOrder['random'] = slideWrapper.methods.fyrandomize(blockSelection);
					
					
					//save image in case of flash replacements, will be available in the the next script version
					slides.each(function()
					{
						$.data(this, "data", { img: $(this).find('img').attr('src')});
					});
			
					if(slideCount <= 1)
						{
							slideWrapper.aviaSlider_preloadhelper({delay:200});
						}
						else
						{
							slideWrapper.aviaSlider_preloadhelper({callback:slideWrapper.methods.preloadingDone});
							slideWrapper.methods.appendControlls();
						}	
						slideWrapper.methods.addDescription();
				},
				
				//appends the click controlls after an element, if that was set in the options array
				appendControlls: function()
				{	
					if (options.slideControlls == 'items')
					{	
						var elementToAppend = options.appendControlls || slideWrapper[0];
						controlls = $('<div></div>').addClass('slidecontrolls').insertAfter(elementToAppend);
						
						slides.each(function(i)
						{	
							var controller = $('<a href="#" class="ie6fix '+current_class+'"></a>').appendTo(controlls);
							controller.bind('click', {currentSlideNumber: i}, slideWrapper.methods.switchSlide);
							current_class = "";
						});	
						
						controlls.width(controlls.width()).css('float','none');
					}
					return this;
					
				},
				
				// adds the image description from an alttag 
				addDescription: function()
				{	
					if(options.showText)
					{
						slides.each(function()
						{	
						
							var currentSlide = $(this);
							
							if(options.captionReplacement)
							{
								var description = currentSlide.find(options.captionReplacement).css({display:'block','opacity':options.backgroundOpacity});
								
							}
							else
							{
								var	description = currentSlide.find('img').attr('alt'),
									splitdesc = description.split('::');
								
								
								
								if(splitdesc[0] != "" )
								{
									if(splitdesc[1] != undefined )
									{
										description = "<strong>"+splitdesc[0] +"</strong>"+splitdesc[1]; 
									}
									else
									{
										description = splitdesc[0];
									}
								}
	
								if(description != "")
								{
									$('<div></div>').addClass('feature_excerpt')
													.html(description)
													.css({display:'block', 'opacity':options.backgroundOpacity})
													.appendTo(currentSlide.find('a')); 
								}
							}
						});
					}
				},
				
				preloadingDone: function()
				{	
					skipSwitch = false;
					
					if($.browser.msie)
					{
						slides.css({'backgroundColor':'#000000','backgroundImage':'none'});
					}
					else
					{
						slides.css({'backgroundImage':'none'});
					}
					
					if(options.autorotation && options.autorotation != 2) 
					{
					slideWrapper.methods.autorotate();
					slideImages.bind("click", function(){ clearInterval(interval); });
					}
				},
				
				autorotate: function()
				{	
					var time = parseInt(options.autorotationSpeed) * 1000 + parseInt(options.animationSpeed) + (parseInt(options.betweenBlockDelay) * blockNumber);
				
					interval = setInterval(function()
					{ 	
						currentSlideNumber ++;
						if(currentSlideNumber == slideCount) currentSlideNumber = 0;
						
						slideWrapper.methods.switchSlide();
					},
					time);
				},
				
				switchSlide: function(passed)
				{ 
					var noAction = false;
						
					if(passed != undefined && !skipSwitch)
					{	
						if(currentSlideNumber != passed.data.currentSlideNumber)
						{	
							currentSlideNumber = passed.data.currentSlideNumber;
						}
						else
						{
							noAction = true;
						}
					}
						
					if(passed != undefined) clearInterval(interval);
					
					if(!skipSwitch && noAction == false)
					{	
						skipSwitch = true;
						var currentSlide = slides.filter(':visible'),
							nextSlide = slides.filter(':eq('+currentSlideNumber+')'),
							nextURL = $.data(nextSlide[0], "data").img,	
							nextImageBG = 'url('+nextURL+')';	
							if(options.slideControlls)
							{	
								controlls.find('.active_item').removeClass('active_item');
								controlls.find('a:eq('+currentSlideNumber+')').addClass('active_item');									
							}

						blockSelectionJQ = blockOrder[options.display];
						
						//workarround to make more than one flash movies with the same classname possible
						slides.find('>a>img').css({opacity:1,visibility:'visible'});
							
						//switchmovement
						if(options.switchMovement && (options.display == "topleft" || options.display == "diagonaltop"))
						{
								if(reverseSwitch == false)
								{	
									blockSelectionJQ = blockOrder[options.display];
									reverseSwitch = true;							
								}
								else
								{	
									if(options.display == "topleft") blockSelectionJQ = blockOrder['bottomright'];
									if(options.display == "diagonaltop") blockSelectionJQ = blockOrder['diagonalbottom'];
									reverseSwitch = false;							
								}
						}	
						
						if(options.display == 'random')
						{
							blockSelectionJQ = slideWrapper.methods.fyrandomize(blockSelection);
						}

						if(options.display == 'all')
						{
							blockSelectionJQ = blockOrder[options.transitionOrder[currentTransition]];
							currentTransition ++;
							if(currentTransition >=  options.transitionOrder.length) currentTransition = 0;
						}
						

						//fire transition
						blockSelectionJQ.css({backgroundImage: nextImageBG}).each(function(i)
						{	
							
							var currentBlock = $(this);
							setTimeout(function()
							{	
								var transitionObject = new Array();
								if(options.transition == 'drop')
								{
									transitionObject['css'] = {height:1, width:options.blockSize.width, display:'block',opacity:0};
									transitionObject['anim'] = {height:options.blockSize.height,width:options.blockSize.width,opacity:1};
								}
								else if(options.transition == 'fade')
								{
									transitionObject['css'] = {display:'block',opacity:0};
									transitionObject['anim'] = {opacity:1};
								}
								else
								{
									transitionObject['css'] = {height:1, width:1, display:'block',opacity:0};
									transitionObject['anim'] = {height:options.blockSize.height,width:options.blockSize.width,opacity:1};
								}
							
								currentBlock
								.css(transitionObject['css'])
								.animate(transitionObject['anim'],options.animationSpeed, function()
								{ 
									if(i+1 == blockNumber)
									{	
										slideWrapper.methods.changeImage(currentSlide, nextSlide);
									}
								});
							}, i*options.betweenBlockDelay);
						});
						
					} // end if(!skipSwitch && noAction == false)
					
					return false;
				},
				
				changeImage: function(currentSlide, nextSlide)
				{	
					currentSlide.css({zIndex:0, display:'none'});
					nextSlide.css({zIndex:3, display:'block'});
					blockSelectionJQ.fadeOut(800, function(){ skipSwitch = false; });
				},
				
				// array sorting
				fyrandomize: function(object) 
				{	
					var length = object.length,
						objectSorted = $(object);
						
					if ( length == 0 ) return false;
					
					while ( --length ) 
					{
						var newObject = Math.floor( Math.random() * ( length + 1 ) ),
							temp1 = objectSorted[length],
							temp2 = objectSorted[newObject];
						objectSorted[length] = temp2;
						objectSorted[newObject] = temp1;
					}
					return objectSorted;
				},
				
				kcubit: function(object)
				{
					var length = object.length, 
						objectSorted = $(object),	
						currentIndex = 0,		//index of the object that should get the object in "i" applied
						rows = Math.ceil(slideHeight / options.blockSize.height),
						columns = Math.ceil(slideWidth / options.blockSize.width),
						oneColumn = blockNumber/columns,
						oneRow = blockNumber/rows,
						modX = 0,
						modY = 0,
						i = 0,
						rowend = 0,
						endreached = false,
						onlyOne = false; 
					
					if ( length == 0 ) return false;
					for (i = 0; i<length; i++ ) 
					{
						objectSorted[i] = object[currentIndex];
						
						if((currentIndex % oneRow == 0 && blockNumber - i > oneRow)|| (modY + 1) % oneColumn == 0)
						{						
							currentIndex -= (((oneRow - 1) * modY) - 1); modY = 0; modX ++; onlyOne = false;
							
							if (rowend > 0)
							{
								modY = rowend; currentIndex += (oneRow -1) * modY;
							}
						}
						else
						{
							currentIndex += oneRow -1; modY ++;
						}
						
						if((modX % (oneRow-1) == 0 && modX != 0 && rowend == 0) || (endreached == true && onlyOne == false) )
						{	
							modX = 0.1; rowend ++; endreached = true; onlyOne = true;
						}	
					}
					
				return objectSorted;						
				}
			};
			
			slideWrapper.methods.init();	
		});
	};
})(jQuery);





(function($)
{
	$.fn.aviaSlider_preloadhelper = function(variables, callback) 
	{
		var defaults = 
		{
			fadeInSpeed: 800,
			maxLoops: 10,
			callback: ''
		};
		
		var options = $.extend(defaults, variables);
			
		return this.each(function()
		{
			var container 	= $(this),
				images		= $('img', this).css({opacity:0, visibility:'visible', display:'block'}),
				parent = images.parent(),
				imageCount = images.length,
				interval = '',
				allImages = images ;
				
			
			var methods = 
			{
				checkImage: function()
				{
					images.each(function(i)
					{
						if(this.complete == true) images = images.not(this);
					});
					
					if(images.length && options.maxLoops >= 0)
					{
						options.maxLoops--;
						setTimeout(methods.checkImage, 500);
					}
					else
					{
						methods.showImages();
					}
				},
				
				showImages: function()
				{
					allImages.each(function(i)
					{
						var currentImage = $(this);
						currentImage.animate({opacity:1}, options.fadeInSpeed, function()
						{
							if(allImages.length == i+1) methods.callback(i);
						});
					});
				},
				
				callback: function()
				{				
					if (variables instanceof Function) { callback = variables; }
					if (callback  instanceof Function) { callback.call(this);  }
					if(options.callback != '') (options.callback)();

				}
			};
			
			methods.checkImage();

		});
	};
})(jQuery);



(function($)
{
	$.fn.aviaSlider_externalControlls = function(options) 
	{
		var defaults = 
		{
			slideControlls: 'a',
			newControlls: '.slideThumb'
		};
		
		var options = $.extend(defaults, options);
	
		return this.each(function()
		{
			var container = $(this).css('display','none'),
				controlls = $(options.slideControlls, container),
				newControlls = $(options.newControlls).css('cursor','pointer');

				newControlls.each(function(i){
				
					$(this).click(function()
					{
						$(controlls[i]).trigger('click');
						return false;
					});
				});
		});
	}
})(jQuery);

