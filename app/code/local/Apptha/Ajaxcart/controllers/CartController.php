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
require_once 'Mage/Checkout/controllers/CartController.php';
class Apptha_Ajaxcart_CartController extends Mage_Checkout_CartController
{
   

    /**
     * Update shoping cart data action
     */
    public function updatePostAction()
    {
  $isAjaxProRequest = $this->getRequest()->getParam('ajaxview', false); 
      
  if($isAjaxProRequest)
  {
        try {                              
            $cartData = $this->getRequest()->getParam('cart');
            if (is_array($cartData))
             {
                $cart = $this->_getCart();
                $cart->updateItems($cartData)
                    ->save();
            }
            $this->_getSession()->setCartWasUpdated(true);
            if ($this->_getSession()->getQuote()->getHasError()) {
                $this->_getSession()->getQuote()->setMessages(array());
                $this->_getSession()->getQuote()->setHasError(false);
                return; //reload shopping cart page
            }
            $this->_getSession()->getQuote()->setMessages(array());
            //return $this->_sendJson($this->_generateResponse(__('Update successful')));
        }
        catch (Exception $e)
        {
            $message = $e->getMessage();
        }
      $response = Mage::getModel('ajaxcart/ajaxresponse');
      $response->setCart(Mage::helper('ajaxcart')->rendercartpageUpdate()); 
      $response->setLinks(Mage::helper('ajaxcart')->topLinkTitle());
      $response->send();
    }
    else
    {
          return  parent::updatePostAction();
    }
    }

    /**
     * Delete shoping cart item action
     */
  


    
}