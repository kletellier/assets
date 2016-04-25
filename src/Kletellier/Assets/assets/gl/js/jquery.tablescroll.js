/*

Copyright (c) 2009 Dimas Begunoff, http://www.farinspace.com

Licensed under the MIT license
http://en.wikipedia.org/wiki/MIT_License

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.

*/

;(function($){

	var scrollbarWidth = 0;
	 
	 function msieversion() {
            var ua = window.navigator.userAgent;
            var msie = ua.indexOf("MSIE ");

            if (msie > 0)      // If Internet Explorer, return version number
                return true;
            else                 // If another browser, return 0
                return false;

            return false;
        }

	// http://jdsharp.us/jQuery/minute/calculate-scrollbar-width.php
	function getScrollbarWidth() 
	{
		if (scrollbarWidth) return scrollbarWidth;
		var div = $('<div style="width:50px;height:50px;overflow:hidden;position:absolute;top:-200px;left:-200px;"><div style="height:100px;"></div></div>'); 
		$('body').append(div); 
		var w1 = $('div', div).innerWidth(); 
		div.css('overflow-y', 'auto'); 
		var w2 = $('div', div).innerWidth(); 
		$(div).remove(); 
		scrollbarWidth = (w1 - w2);
		return scrollbarWidth;
	}
	
	$.fn.tableScroll = function(options)
	{
		if (options == 'undo')
		{
			var container = $(this).parent().parent();
			if (container.hasClass('tablescroll_wrapper')) 
			{
				container.find('.tablescroll_head thead').prependTo(this);
				container.find('.tablescroll_foot tfoot').appendTo(this);
				container.before(this);
				container.empty();
			}
			return;
		}

		var settings = $.extend({},$.fn.tableScroll.defaults,options);
		
		// Bail out if there's no vertical overflow
		//if ($(this).height() <= settings.height)
		//{
		//  return this;
		//}

		settings.scrollbarWidth = getScrollbarWidth();

		this.each(function()
		{		
			var start = new Date().getTime();
			var flush = settings.flush;
			
			var tb = $(this).addClass('tablescroll_body');
			
            // find or create the wrapper div (allows tableScroll to be re-applied)
            var wrapper;
            if (tb.parent().hasClass('tablescroll_wrapper')) {
                wrapper = tb.parent();
            }
            else {
                wrapper = $('<div class="tablescroll_wrapper"></div>').insertBefore(tb).append(tb);            	
            }

			// check for a predefined container
			if (!wrapper.parent('div').hasClass(settings.containerClass))
			{
				$('<div></div>').addClass(settings.containerClass).insertBefore(wrapper).append(wrapper);
			}		

			var width = settings.width ? settings.width : tb.outerWidth();			
			
			
			/*
			* GL 08.08.14 ajout d'une css pour gérer la taille
			*
			*/			
			if(settings.csswidth!='')
			{				
				wrapper.addClass(settings.csswidth);
				wrapper.css
				({					
					'height': settings.height+'px',
					'overflow': 'auto'					
				});		
				width = wrapper.outerWidth();				
			}
			else
			{			
				wrapper.css
				({					
					'width': width  +'px',
					'height': settings.height+'px',
					'overflow': 'auto'					
				});			
			}			
			

			tb.css('width',width+'px');	
			
			// ajout d'une class border demande GDN
			// on applique une première fois la classe pour que les calculs
			// tiennent compte de la différence des bordures
			if(settings.borderClass!='')
			{
				 $(".tablescroll_head").addClass(settings.borderClass);
				 $(".tablescroll_wrapper").addClass(settings.borderClass);
				 $(".tablescroll_foot").addClass(settings.borderClass);
			}
			
			// with border difference
			var wrapper_width = wrapper.outerWidth(); // GL gourmand en ressource (2/3 du temps)

			// GL gestion de la taille du scrollbar sous IE (outerwidth ne semble pas prendre en compte la largeur du scrollbar)
			if(!msieversion())
			{		
				var diff = wrapper_width-width;
				var vWidth = ((width-diff)+settings.scrollbarWidth);				
			
				// assume table will scroll
				wrapper.css({width: vWidth +'px'});
				tb.css('width',(width-diff)+'px');
			}	 	

			if (tb.outerHeight() <= settings.height)
			{
				wrapper.css({height:'auto',width:(width-diff)+'px'});
				flush = false;
			}		

			// using wrap does not put wrapper in the DOM right 
			// away making it unavailable for use during runtime
			// tb.wrap(wrapper);

			// possible speed enhancements
			var has_thead = $('thead',tb).length ? true : false ;
			var has_tfoot = $('tfoot',tb).length ? true : false ;
			var thead_tr_first = $('thead tr:first',tb);
			var tbody_tr_first = $('tbody tr:first',tb);
			var tfoot_tr_first = $('tfoot tr:first',tb);
						
			// remember width of last cell
			var w = 0;

			
			$('th, td',thead_tr_first).each(function(i)
			{				 
				w = $(this).width();			
				$('th:eq('+i+'), td:eq('+i+')',thead_tr_first).css('width',w+'px');
				$('th:eq('+i+'), td:eq('+i+')',tbody_tr_first).css('width',w+'px');
				if (has_tfoot) $('th:eq('+i+'), td:eq('+i+')',tfoot_tr_first).css('width',w+'px');
			});
			
			
			if (has_thead) 
			{
				var tbh = $('<table class="tablescroll_head" cellspacing="0"></table>').insertBefore(wrapper).prepend($('thead',tb));
			}

			if (has_tfoot) 
			{
				var tbf = $('<table class="tablescroll_foot" cellspacing="0"></table>').insertAfter(wrapper).prepend($('tfoot',tb));
			}

			if (tbh != undefined)
			{
				
				tbh.css('width',width+'px');
				
				if (flush)
				{
					$('tr:first th:last, tr:first td:last',tbh).css('width',(w+settings.scrollbarWidth)+'px');
					var vSize = wrapper.outerWidth();
					// si présence de border on rallonge le thead
					if(settings.borderSize!='')
					{
						vSize+=(2*settings.borderSize);
					}
					tbh.css('width',vSize + 'px');
				}
			}

			if (tbf != undefined)
			{
				tbf.css('width',width+'px');

				if (flush)
				{
					$('tr:first th:last, tr:first td:last',tbf).css('width',(w+settings.scrollbarWidth)+'px');
					tbf.css('width',wrapper.outerWidth() + 'px');
				}
			}
			
				// GL ajout du pyjama
			if(settings.pyjClass!='')
			{			 
				$('tbody > tr:odd').addClass(settings.pyjClass);
			}	
			
			// ajout du mouseover
			if(settings.moClass!='')
			{
				$('tbody > tr').mouseover(function()
				{
				$(this).addClass(settings.moClass);
				});
				
				$('tbody > tr').mouseout(function()
				{
				$(this).removeClass(settings.moClass);
				});
			}
			
			// ajout des border
			if(settings.borderSize!='')
			{
				var vTxt = "solid " + settings.borderSize + "px ";
				if(settings.borderColor!='')
					{
					vTxt += " #" + settings.borderColor;
					}
				 
				 $(".tablescroll_head").css("border-top",vTxt);
				 $(".tablescroll_head").css("border-bottom",vTxt);
				 $(".tablescroll_head").css("border-left",vTxt);
				 $(".tablescroll_head").css("border-right",vTxt);
				 $(".tablescroll_wrapper").css("border-right",vTxt);
				 $(".tablescroll_wrapper").css("border-left",vTxt);
				 $(".tablescroll_wrapper").css("border-bottom",vTxt);
			}	
			
			// ajout d'une class border demande GDN
			// on supprime la class border et on la rajoute (sinon elle est dégagée du thead)
			if(settings.borderClass!='')
			{
				 $(".tablescroll_head").removeClass(settings.borderClass);
				 $(".tablescroll_wrapper").removeClass(settings.borderClass);
				 $(".tablescroll_foot").removeClass(settings.borderClass);
				 $(".tablescroll_head").addClass(settings.borderClass);
				 $(".tablescroll_wrapper").addClass(settings.borderClass);
				 $(".tablescroll_foot").addClass(settings.borderClass);
				 // 2013.06.06 demande GDN suppression du scrollbar horizontal
				 $(".tablescroll_wrapper").css("overflow-x","hidden");
			}		 
		});		
		
		return this;
	};

	// public
	$.fn.tableScroll.defaults =
	{
		flush: true, // makes the last thead and tbody column flush with the scrollbar
		csswidth: '', // css for table width
		width: null, // width of the table (head, body and foot), null defaults to the tables natural width
		height: 100, // height of the scrollable area
		containerClass: 'tablescroll', // the plugin wraps the table in a div with this css class
		pyjClass:'', // class pour le pyjama
		moClass:'', // class mouseover
		borderSize:'', // size du border
		borderColor:'', // couleur du border
		borderClass:''
	};

})(jQuery);
