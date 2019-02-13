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
class Apptha_Ajaxcart_Block_Adminhtml_Ajaxcart extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_ajaxcart';
    $this->_blockGroup = 'ajaxcart';
    $this->_headerText = Mage::helper('ajaxcart')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('ajaxcart')->__('Add Item');
    parent::__construct();
  }
}