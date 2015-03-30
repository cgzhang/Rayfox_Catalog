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
 * @version 0.2.1
 */
class Rayfox_Catalog_Helper_Data extends Mage_CatalogInventory_Helper_Data
{
	const XML_PATH_SORT_OUT_OF_STOCK    = 'cataloginventory/options/sort_out_of_stock_at_bottom';
	const XML_PATH_SORT_OUT_OF_STOCK_SEARCH_RESULT = 'cataloginventory/options/sort_out_of_stock_at_bottom_for_search';
	
	public function isSortOutOfStockProductsAtBottomEnabled()
	{
		return $this->isShowOutOfStock() && Mage::getStoreConfigFlag(self::XML_PATH_SORT_OUT_OF_STOCK);
	}

	public function isEnabledForSearchResults()
	{
		return $this->isShowOutOfStock() && Mage::getStoreConfigFlag(self::XML_PATH_SORT_OUT_OF_STOCK_SEARCH_RESULT);
	}
}