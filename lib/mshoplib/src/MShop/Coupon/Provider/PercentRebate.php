<?php

/**
 * @copyright Copyright (c) Metaways Infosystems GmbH, 2012
 * @license LGPLv3, http://www.arcavias.com/en/license
 * @package MShop
 * @subpackage Coupon
 */


/**
 * Percentage price coupon model.
 *
 * @package MShop
 * @subpackage Coupon
 */
class MShop_Coupon_Provider_PercentRebate
	extends MShop_Coupon_Provider_Abstract
	implements MShop_Coupon_Provider_Factory_Interface
{
	/**
	 * Adds the result of a coupon to the order base instance.
	 *
	 * @param MShop_Order_Item_Base_Interface $base Basic order of the customer
	 */
	public function addCoupon( MShop_Order_Item_Base_Interface $base )
	{
		if( $this->_getObject()->isAvailable( $base ) === false ) {
			return;
		}

		$config = $this->_getItem()->getConfig();

		if( !isset( $config['percentrebate.productcode'] ) || !isset( $config['percentrebate.rebate']) )
		{
			throw new MShop_Coupon_Exception( sprintf(
				'Invalid configuration for coupon provider "%1$s", needs "%2$s"',
				$this->_getItem()->getProvider(), 'percentrebate.productcode, percentrebate.rebate'
			) );
		}


		$priceManager = MShop_Factory::createManager( $this->_getContext(), 'price' );
		$prices = $this->_getPriceByTaxRate( $base );
		$orderProducts = array();

		krsort( $prices );

		foreach( $prices as $taxrate => $price )
		{
			$sum = $price->getValue() + $price->getCosts();
			$rebate = round( $sum * (float) $config['percentrebate.rebate'] / 100, 2 );

			$price = $priceManager->createItem();
			$price->setValue( -$rebate );
			$price->setRebate( $rebate );
			$price->setTaxRate( $taxrate );

			$orderProduct = $this->_createProduct( $config['percentrebate.productcode'], 1 );
			$orderProduct->setPrice( $price );

			$orderProducts[] = $orderProduct;
		}

		$base->addCoupon( $this->_getCode(), $orderProducts );
	}
}
