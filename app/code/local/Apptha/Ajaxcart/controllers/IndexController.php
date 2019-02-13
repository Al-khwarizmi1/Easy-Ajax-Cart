<?php
/**
 * @name         :  Easy Ajax Cart
 * @version      :  1.0
 * @since        :  Magento 1.4
 * @author       :  Apptha - http://www.apptha.com
 * @copyright    :  Copyright (C) 2011 Powered by Apptha
 * @license      :  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @Creation Date:  October 22 2011
 * 
 * */
class Apptha_Ajaxcart_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    { 				
		$this->loadLayout();     
		$this->renderLayout();
    }
	
    
 	public function removeAction() 
 	{
        $response = Mage::getModel('ajaxcart/ajaxresponse');
        $id =  $this->getRequest()->getParam('id');
        Mage::getSingleton('checkout/cart')->removeItem($id)->save();
        if(!$this->getRequest()->getParam('is_checkout')) 
        {
        
            $response->setCart(Mage::helper('ajaxcart')->cartItems());
        }
 	else 
 	{
            $cart = '';
            $response->setCart(Mage::helper('ajaxcart')->rendercartpageUpdate());
        }
        $response->setLinks(Mage::helper('ajaxcart')->topLinkTitle());
        
        $response->send();
    }
}