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
class Apptha_Ajaxcart_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function cartItems() {
        return  Mage::getSingleton('core/layout')
                ->createBlock('checkout/cart_sidebar')
                ->addItemRender('simple', 'checkout/cart_item_renderer', 'checkout/cart/sidebar/default.phtml')
                ->addItemRender('configurable', 'checkout/cart_item_renderer_configurable', 'checkout/cart/sidebar/default.phtml')
                ->addItemRender('grouped', 'checkout/cart_item_renderer_grouped', 'checkout/cart/sidebar/default.phtml')
                ->addItemRender('bundle', 'bundle/checkout_cart_item_renderer', 'checkout/cart/sidebar/default.phtml')
                ->setTemplate('checkout/cart/sidebar.phtml')
                ->renderView();
    }

    public function rendercartpageUpdate() 
    {

        $layout = Mage::getSingleton('core/layout');


        $totals = $layout
                ->createBlock('checkout/cart_totals')
                ->setTemplate('checkout/cart/totals.phtml')
        ;
        $shipping = $layout
                ->createBlock('checkout/cart_shipping')
                ->setTemplate('checkout/cart/shipping.phtml')
        ;

        $coupon = $layout
                ->createBlock('checkout/cart_coupon')
                ->setTemplate('checkout/cart/coupon.phtml')
        ;

        // top methods

        $t_onepage = $layout
                ->createBlock('checkout/onepage_link')
                ->setTemplate('checkout/onepage/link.phtml')
        ;
        $t_methods = $layout
                ->createBlock('core/text_list')
                ->append($t_onepage, 'top_methods');


        //methods
        $onepage = $layout
                ->createBlock('checkout/onepage_link')
                ->setTemplate('checkout/onepage/link.phtml')
        ;

        $multishipping = $layout
                ->createBlock('checkout/multishipping_link')
                ->setTemplate('checkout/multishipping/link.phtml')
        ;




        $methods = 	$layout
                ->createBlock('core/text_list')
                ->append($onepage, "onepage")
                ->append($multishipping, "multishipping");


        // Cross-sales etc

        $crossell = $layout
                ->createBlock('checkout/cart_crosssell')
                ->setTemplate('checkout/cart/crosssell.phtml')
        ;


        Mage::getSingleton('checkout/session')->setCartWasUpdated(true);

        $cartupdate = $layout
                ->createBlock('checkout/cart')
                ->setEmptyTemplate('checkout/cart/noItems.phtml')
                ->setCartTemplate('checkout/cart.phtml')
                ->addItemRender('simple', 'checkout/cart_item_renderer', 'checkout/cart/item/default.phtml')
                ->addItemRender('configurable', 'checkout/cart_item_renderer_configurable', 'checkout/cart/item/default.phtml')
                ->addItemRender('grouped', 'checkout/cart_item_renderer_grouped', 'checkout/cart/item/default.phtml')
                ->addItemRender('downloadable', 'downloadable/checkout_cart_item_renderer', 'downloadable/checkout/cart/item/default.phtml')
                ->addItemRender('bundle', 'bundle/checkout_cart_item_renderer', 'checkout/cart/item/default.phtml')
                ->addItemRender('subscription_simple', 'sarp/checkout_cart_item_renderer_simple', 'checkout/cart/item/default.phtml')
                ->addItemRender('bookable', 'booking/checkout_cart_item_renderer', 'checkout/cart/item/default.phtml')
                ->setTemplate('checkout/cart.phtml')
                ->setChild('top_methods',$t_methods)
                ->setChild('totals', $totals)
                ->setChild('shipping', $shipping)
                ->setChild('coupon', $coupon)
                ->setChild('methods', $methods)
                ->setChild('crosssell', $crossell)
        ;
        $cartupdate
                ->chooseTemplate();
        return trim($cartupdate
                ->renderView());
    }
    public function topLinkTitle() 
    {
        $count = Mage::helper('checkout/cart')->getSummaryCount();
        if( $count == 1 ) 
        {
            $text = Mage::helper('checkout')->__('My Cart (%s item)', $count);
        } 
        elseif( $count > 0 ) 
        {
            $text = Mage::helper('checkout')->__('My Cart (%s items)', $count);
        } 
        else 
        {
            $text = Mage::helper('checkout')->__('My Cart');
        }
        return $text;
    }


}