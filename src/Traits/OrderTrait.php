<?php
/**
 * @package    Enhanced Hikashop cart cleaner.
 * @author     https://www.brainforge.co.uk
 * @copyright  (C) 2025 Jonathan Brain. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Brainforgeuk\Plugin\Hikashop\BfCleanCart\Traits;

\defined('_JEXEC') or die;

/**
 */
trait OrderTrait
{
	/**
	 */
	public function onAfterOrderCreate(&$order, &$send_email)
	{
		$this->onOrderCleanCart($order);
	}

	/**
	 */
	public function onAfterOrderUpdate(&$order, &$send_email)
	{
		$this->onOrderCleanCart($order);
	}

	/**
	 */
	protected function onOrderCleanCart(&$order)
	{
		$completedOrderStatii = $this->params->get('completedorderstatii');
		if (!empty($completedOrderStatii) &&
			in_array($order->order_status, $completedOrderStatii))
		{
			$cartClass = hikashop_get('class.cart');
			$cartClass->cleanCartFromSession();
		}
	}
}