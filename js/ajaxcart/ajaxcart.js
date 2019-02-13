/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

oldLocation = setLocation;
/* setLocation function starts
 * it wraps the original setlocation function*/
setLocation = function(url) {
if(ajaxcart.ajaxcartEnable == 1 &&(ajaxcart.ajaxcartUpdate == 1 ||ajaxcart.ajaxcartUpdate == 3))
{
	if (url.search('checkout/cart/add') != -1) {
		ajaxcartupdate(url + 'ajaxview/1/');
	} else if (url.search('options=cart') != -1) {
		ajaxcustomoption(url + '&ajaxcustomoption=1');
	} else {
		window.location.href = url;
	}
}
else
	{
	window.location.href = url;
	}
}
/* setLocation function starts */

/*
 * AjaxcartUpdate function starts it updates recently added items and menu
 */
function ajaxcartupdate(url) {

	if (ajaxcart.cartUrl == 1) {
		ajaxcartpageupdate(url);
	} else {
		if(document.getElementById('popup-block').style.display != 'block'){
		loadingbox = new Lightbox('loading-box');
		loadingbox.open();

		var request = new Ajax.Request(
				url,
				{
					method : 'post',
					onSuccess : function(transport) {
						if (transport.status == 200)
						{
							var data = transport.responseText.evalJSON();
							var shipment_methods = $$('div.block-cart').first();
							var toptitle = $$('a.top-link-cart').first();
							shipment_methods
									.update('<div class="loading-ajax">sadadadsad</div>');
							if (typeof shipment_methods != 'undefined'
									&& shipment_methods != null)
							{

								shipment_methods_found = true;
							}
                                                        if(toptitle)
                                                          {
                                                            toptitle.innerHTML = data.links;
                                                          }
							if (shipment_methods_found)
							{
								shipment_methods.update(data.cart);
								//toptitle.innerHTML = data.links;
								DeleteLinks();
                                                                loadingbox.close();
								
								// test1.close();
							}
                                                        if(url.search('checkout/cart/add') != -1)
							{
								$('product-name').innerHTML = data.product_name;
								$('product-img').innerHTML = $('product-img').innerHTML = "<img src='"+data.product_image+"' width='70' height='70'>";
								test1 = new Lightbox('popup-block');
								test1.open();
								}
							if (data.success) {

							}

						}
					}
				});
	}
}}
/* AjaxcartUpdate function Ends */

/* Ajaxcustom options function Starts
 * its adds the custom options */
function ajaxcustomoption(url)
{
    loadingbox = new Lightbox('loading-box');
		loadingbox.open();
	var request = new Ajax.Request(url, {
		method : 'post',
		onSuccess : function(transport) {
			var data = transport.responseText;
                        loadingbox.close();
			//window.document.body.appendChild(data);
			$('custom-option').innerHTML = data;
			 productAddToCartForm = new VarienForm('product_addtocart_form');
			 addEvent();
			test1 = new Lightbox('custom-option');
			test1.open();

		}
	});
}

/* Ajaxcustom options function Starts */

/* DeleteLinks function Starts
 * it update the delete links to the recently added items*/
function DeleteLinks() {
	var links = document.links;

	for (i = 0; i < links.length; i++) {
		if (links[i].href.search('checkout/cart/delete') != -1) {
			url = links[i].href.replace(/\/uenc\/.+,/g, "");
			var del = url.match(/delete\/id\/\d+\//g);
			var id = del[0].match(/\d+/g);
			if (window.location.protocol == 'https:') {
				base_url = base_url.replace("http:", "https:");
			}
			if (ajaxcart.cartUrl != 1) {
				links[i].href = 'javascript:ajaxcartdelete("' + base_url
						+ 'ajaxcart/index/remove/id/' + id + '")';
			} else {

				links[i].href = 'javascript:ajaxcartdelete("' + base_url
						+ 'ajaxcart/index/remove/id/' + id + '/is_checkout/1")';
			}

		}
	}
}

/* DeleteLinks function Starts */

/* ajaxcartdelete function Starts
 * it triggers when click the delete link in recently added items */
function ajaxcartdelete(url)
{
	ajaxcartupdate(url);
}
/* ajaxcartdelete function Ends */

/* Ajaxcart class  function Starts */
var Ajaxcart = Class.create();
Ajaxcart.prototype =
{
	initialize : function(cartUrl,ajaxcartEnable,ajaxcartUpdate)
	{
		this.cartUrl = cartUrl;
		this.ajaxcartEnable = ajaxcartEnable;
		this.ajaxcartUpdate = ajaxcartUpdate;
	}
}
/* Ajaxcart class  function Ends */

window.onload = function()
{

domload();

}
function domload()
{
	if ((typeof ('.cart') != 'undefined') && (ajaxcart.cartUrl)) {

		DeleteLinks();
	}
	var shoppingCartTable = $('shopping-cart-table');
	if (shoppingCartTable)
	{
		  var shoppingCartForm = shoppingCartTable.up('form');
	      if(typeof shoppingCartForm != 'undefined'){
	          shoppingCartForm.observe('submit', function(event) {
	              Event.stop(event);
	              var params = Event.element(event).serialize();
	              var url = Event.element(event).action;
	          ajaxupdatepost(url,params);
	          return false;
	          });
	      }

	 }
}

/* ajaxcartpageupdate  function Starts
 * it triggers when click delete link in cartpage */

function ajaxcartpageupdate(url)
{
    
	var request = new Ajax.Request(url, {
		method : 'post',
		onSuccess : function(transport) {
			if (transport.status == 200) {
				var data = transport.responseText.evalJSON();
				var shipment_methods = $$('div.block-cart').first();
				var toptitle = $$('a.top-link-cart').first();
				var cartpage = $$('.cart').first();
				cartpage.innerHTML = data.cart
				toptitle.innerHTML = data.links
				if ($('shopping-cart-table')) {
					decorateTable('shopping-cart-table');
					DeleteLinks();
					domload();
				}
				if (typeof shipment_methods != 'undefined'
						&& shipment_methods != null) {

					shipment_methods_found = true;
				}

				if (shipment_methods_found) {
					shipment_methods.update(data.cart);
					toptitle.innerHTML = data.links;
					DeleteLinks();

				}

				if (data.success) {

				}

			}
		}
	});
}
/* ajaxcartpageupdate  function Ends */

var productAddToCartForm = new VarienForm('product_addtocart_form');
if(!Prototype.Browser.IE6){

    var cnt1 = 20;
	__intId = setInterval(

		function(){

		 addEvent();
		},
		500
	);
	addEvent();

}
/* addEvent  function Starts */

function addEvent()
{

    productAddToCartForm.submit = function(url)
    {
    	if(document.getElementById('popup-block').style.display != 'block'){
    	if(this.validator && this.validator.validate())
    	{

    	var url = url+ '?ajaxview=1'
        
     
    	var updatetest = $('product_addtocart_form').action;
    	if(updatetest.search('/updateItemOptions/') != -1)
		{
    		return this.form.submit();
		}
    	if(ajaxcart.ajaxcartUpdate == 1 )
    {
    		return this.form.submit();
    }
    	
    	$('product_addtocart_form').action += url;
         loadingbox = new Lightbox('loading-box');
		loadingbox.open();
    	 $('product_addtocart_form').request(
				{
                                        
					onComplete : function(transport) {
						try{
						if (transport.status == 200)
						{
							var data = transport.responseText.evalJSON();
							var shipment_methods = $$('div.block-cart').first();
							var toptitle = $$('a.top-link-cart').first();

							if (typeof shipment_methods != 'undefined'
									&& shipment_methods != null) {

								shipment_methods_found = true;
							}

							if (shipment_methods_found)
							{
								shipment_methods.update(data.cart);
								toptitle.innerHTML = data.links;
								DeleteLinks();
                                                                if(url.search('ajaxlist') == -1)
                                                                 {
								if(url.search('ajaxview') != -1)
								{
                                                                $('product-name').innerHTML = data.product_name;
                                                                $('product-img').innerHTML = "<img src='"+data.product_image+"' width='70' height='70'>";
                                                                loadingbox.close();
								test1 = new Lightbox('popup-block');
								test1.open();
								}
                                                                 }
                                                                 else
                                                                   {
                                                                        loadingbox.close();
                                                                        test1.close();
                                                                   }
								// test1.close();
							}

							if (data.success) {

							}

						} }
						catch(e){
							return obj.form.submit();
						}
					}
				});
    }
       
    }
    	 return false;
    }

}
/* addEvent  function Ends */

/* ajaxupdatepost  function Starts */

function ajaxupdatepost(url,params)
{
	var url = url+'?ajaxview=1';
	var request = new Ajax.Request(url, {
		method : 'post',
		parameters:params,
		onSuccess : function(transport) {
			if (transport.status == 200) {
				var data = transport.responseText.evalJSON();
				var shipment_methods = $$('div.block-cart').first();
				var toptitle = $$('a.top-link-cart').first();
				var cartpage = $$('.cart').first();
				cartpage.innerHTML = data.cart
				toptitle.innerHTML = data.links
				if ($('shopping-cart-table')) {
					decorateTable('shopping-cart-table')
					alert("Cart Update Sucessfully");
					DeleteLinks();
					domload();
				}
				if (typeof shipment_methods != 'undefined'
						&& shipment_methods != null) {

					shipment_methods_found = true;
				}

				if (shipment_methods_found) {
					shipment_methods.update(data.cart);
					toptitle.innerHTML = data.links;

				}

				if (data.success) {

				}

			}
		}
	});
}
/* ajaxupdatepost  function Ends */
