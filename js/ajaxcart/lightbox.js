/**
 * @name         :  Apptha One Step Checkout
 * @version      :  1.1
 * @since        :  Magento 1.4
 * @author       :  Apptha - http://www.apptha.com
 * @copyright    :  Copyright (C) 2011 Powered by Apptha
 * @license      :  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @Creation Date:  June 20 2011
 * 
 * */

/**
* Lightbox
*
* This libary is used to create a lightbox in a web application.  This library
* requires the Prototype 1.6 library and Script.aculo.us core, effects, and dragdrop
* libraries.  To use, add a div containing the content to be displayed anywhere on 
* the page.  To create the lightbox, add the following code:
*
*	var test;
*	
*	Event.observe(window, 'load', function () {
*		test = new Lightbox('idOfMyDiv');
*	});
*	
*	Event.observe('lightboxLink', 'click', function () {
*		test.open();
*	});
*
*	Event.observe('closeLink', 'click', function () {
*		test.close();
*	});
*     
*/

var Lightbox = Class.create({
	open : function () {
		this._centerWindow(this.container);
		this._fade('open', this.container);
	},
	
	close : function () {
		this._fade('close', this.container);
	},
	
	_fade : function fadeBg(userAction,whichDiv){
		if(userAction=='close'){
			new Effect.Opacity('bg_fade',
					   {duration:.5,
					    from:0.5,
					    to:0,
					    afterFinish:this._makeInvisible,
					    afterUpdate:this._hideLayer(whichDiv)});
		}else{
			new Effect.Opacity('bg_fade',
					   {duration:.5,
					    from:0,
					    to:0.5,
					    beforeUpdate:this._makeVisible,
					    afterFinish:this._showLayer(whichDiv)});
		}
	},
	
	_makeVisible : function makeVisible(){
		$("bg_fade").style.visibility="visible";
	},

	_makeInvisible : function makeInvisible(){
		$("bg_fade").style.visibility="hidden";
	},

	_showLayer : function showLayer(userAction){
		$(userAction).style.display="block";
	},
	
	_hideLayer : function hideLayer(userAction){
		$(userAction).style.display="none";
	},
	
	_centerWindow : function centerWindow(element) {
		var windowHeight = parseFloat($(element).getHeight())/2; 
		var windowWidth = parseFloat($(element).getWidth())/2;
		var x = 0;
		if(document.documentElement.scrollTop >= 
		document.body.scrollTop){ 

		x = 0 + document.documentElement.scrollTop;
		}

		else{

		x = 0 +	document.body.scrollTop;
		}


		var toP = String(x);
		var toPP = toP + "px";
		$(element).style.top = toPP;
		$(element).style.left = "50%";
		//$(element).style.top = Math.round((document.documentElement.clientHeight/2)-($(element).style.height/2)+document.documentElement.scrollTop)+'px';
		//$(element).style.left = Math.round((document.documentElement.clientWidth/2)-($(element).style.width/2))+"px";
		/*if(document.documentElement.scrollTop!='0'){
		if(typeof window.innerHeight != 'undefined') {
			
			$(element).style.top = Math.round((document.body.offsetTop + ((window.innerHeight - $(element).getHeight()))/2) + document.documentElement.scrollTop)+'px';
			$(element).style.left = Math.round(document.body.offsetLeft + ((window.innerWidth - $(element).getWidth()))/4)+'px';
		} else {
			$(element).style.top = Math.round((document.body.offsetTop + ((document.documentElement.offsetHeight - $(element).getHeight()))/2) +document.documentElement.scrollTop)+'px';
			$(element).style.left = Math.round(document.body.offsetLeft + ((document.documentElement.offsetWidth - $(element).getWidth()))/4)+'px';
		}
		}
		else
			{
			$(element).style.top = "50%";
			$(element).style.left = "50%";
		
			}*/
			
	},
	
	initialize : function(containerDiv) {
		this.container = containerDiv;
		if($('bg_fade') == null) {
			var screen = new Element('div', {'id': 'bg_fade'});
			document.body.appendChild(screen);
		}
		
                 
		this._hideLayer(this.container);
	}
});

