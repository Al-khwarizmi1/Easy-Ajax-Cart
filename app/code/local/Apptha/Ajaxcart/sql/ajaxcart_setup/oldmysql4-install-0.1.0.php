<?php

$installer = $this;

$installer->startSetup();
$entityTypeId = 'catalog_product';
$newAttribute = new Mage_Eav_Model_Entity_Setup('core_setup');
//$code = 'my_attribute';
$newAttribute->addAttribute('catalog_product', 'ajaxcart', array(
    'group' => 'Ajaxcartoptions',
    'label' => 'Enable Ajax cart Update for this product',
    'type' => 'int',
    'input' => 'select',
    'default' => '',
    'class' => '',
    'backend' => '',
    'frontend' => '',
    'source' => 'eav/entity_attribute_source_boolean',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'visible_on_front' => true,
    'visible_in_advanced_search' => false,
    'unique' => false,
   
));

//$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
//$setup->addAttributeSet($entityTypeId, $code, $attr);
//$installer->addAttribute($entityTypeId, $code, $data);
//$id = $newAttribute->getAttribute($entityTypeId, $code, 'attribute_id');
//$newAttribute->updateAttribute($entityTypeId, $id, $data, $value=null, $sortOrder=null);
$newAttribute->updateAttribute('catalog_product', 'ajaxcart', 'is_global', Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE);
$installer->endSetup();
