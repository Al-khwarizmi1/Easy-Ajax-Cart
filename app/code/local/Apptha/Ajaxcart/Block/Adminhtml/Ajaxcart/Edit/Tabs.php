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
class Apptha_Ajaxcart_Block_Adminhtml_Ajaxcart_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('ajaxcart_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('ajaxcart')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('ajaxcart')->__('Item Information'),
          'title'     => Mage::helper('ajaxcart')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('ajaxcart/adminhtml_ajaxcart_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}