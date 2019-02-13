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
class Apptha_Ajaxcart_Model_Observer extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('ajaxcart/ajaxcart');
    }
	 public function addtoCart($observer)
	  {
	     $request = Mage::app()->getFrontController()->getRequest();
	  if ( !$request->getParam('in_cart') && !$request->getParam('is_checkout') && $request->getParam('ajaxview'))
			{
	
	            Mage::getSingleton('checkout/session')->setNoCartRedirect(true);            
	            Mage::getModel('ajaxcart/ajaxresponse')
	                ->setCart(Mage::helper('ajaxcart')->cartItems())
	                ->setLinks(Mage::helper('ajaxcart')->topLinkTitle())
	                ->setProductName($observer->getProduct()->getName())
	                ->setProductImage($observer->getProduct()->getImageUrl())
	                ->send();
			}
	  if ( $request->getParam('in_cart'))
		{
			
            Mage::getSingleton('checkout/session')->setNoCartRedirect(true);
         
            Mage::getModel('ajaxcart/ajaxresponse')
                ->setCart(Mage::helper('ajaxcart')->rendercartpageUpdate())
                ->setLinks(Mage::helper('ajaxcart')->topLinkTitle())
                ->setProductName($observer->getProduct()->getName())
                ->setProductImage($observer->getProduct()->getImageUrl())
                ->send();
		}
	  }
	 public function ajaxCustomOptions($observer)
	  	{
		$params = $observer->getControllerAction()->getRequest()->getParams();
        if (!isset($params['options']) || $params['options'] != 'cart' || !isset($params['ajaxcustomoption'])) return;
        $product = Mage::registry('current_product');
        if (!$product->isConfigurable() && $product->getTypeId() != 'simple') {echo 'false'; die;}
        $block = Mage::getSingleton('core/layout');
        $options = $block->createBlock('catalog/product_view_options', 'product_options')
                            ->setTemplate('catalog/product/view/options.phtml')
                            ->addOptionRenderer('text', 'catalog/product_view_options_type_text', 'catalog/product/view/options/type/text.phtml')
                            ->addOptionRenderer('select', 'catalog/product_view_options_type_select', 'catalog/product/view/options/type/select.phtml');
        $price = $block->createBlock('catalog/product_view', 'product_price')
                            ->setTemplate('catalog/product/view/price_clone.phtml');
        $js = $block->createBlock('core/template', 'product_js')
                            ->setTemplate('catalog/product/view/options/js.phtml');
        if ($product->isConfigurable())
        {
            $configurable = $block->createBlock('catalog/product_view_type_configurable', 'product_configurable_options')
                            ->setTemplate('catalog/product/view/type/options/configurable.phtml');
        }
        $main = $block->createBlock('catalog/product_view')
                        ->setTemplate('ajaxcart/customoptions.phtml')
                        ->append($options);
        if ($product->isConfigurable()) $main->append($configurable);
        $main->append($js)->append($price);
        $observer->getControllerAction()->getResponse()->setBody($main->renderView());
        return;
		}
}