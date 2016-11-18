<?php

/**
 * Sort products by stock status.
 *
 * Features:
 * 1. Always show out of stock products on the bottom of the category page.
 * 2. Easy setup, just turn on from Magento backend, and it works!
 * 2. Configurable settings, it depends on "show out of stock product", it will be hidden if not allowed display out of stock products.
 * 3. Support both configurable and simple products now.
 * This source file is subject to the Open Software License (OSL 3.0)
 *
 * @version 0.2.5
 */
class Rayfox_Catalog_Model_Layer extends Mage_Catalog_Model_Layer
{
    public function prepareProductCollection($collection)
    {
        parent::prepareProductCollection($collection);
        if (!Mage::helper('rayfox_catalog')->isSortOutOfStockProductsAtBottomEnabled()) {
            return $this;
        }
        try {
            $websiteId = Mage::app()->getStore()->getWebsiteId();
            if (Mage::helper('catalog')->isModuleEnabled('Mage_CatalogInventory')) {
                
                /*$collection->getSelect()->joinLeft(
                    array('stock_status' => 'cataloginventory_stock_status'),
                    'stock_status.product_id = e.entity_id',
                    array('stock_status')
                );*/

                // fix conflict
                // check if stock_status field already joined (for example, by other extensions)
                $stockStatusFieldExisted = Mage::helper('rayfox_catalog')->checkFieldExisted($collection->getSelect(), 'stock_status');
                //if yes, skip join.
                if(!$stockStatusFieldExisted) {
                    $collection->joinTable(
                        array('cisi' => 'cataloginventory/stock_status'),
                        'product_id=entity_id',
                        array('stock_status'),
                        array('website_id' => $websiteId),
                        'left'
                    );
                    
                }
            }
            $collection->getSelect()->order('stock_status desc');
        } 
        catch (Exception $e) {}
        return $this;
    }
}
