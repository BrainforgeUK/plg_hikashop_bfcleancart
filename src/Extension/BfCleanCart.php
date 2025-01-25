<?php
/**
 * @package    Enhanced Hikashop cart cleaner.
 * @author     https://www.brainforge.co.uk
 * @copyright  (C) 2025 Jonathan Brain. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Brainforgeuk\Plugin\Hikashop\BfCleanCart\Extension;

use Brainforgeuk\Plugin\Hikashop\BfCleanCart\Classes\Browser;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Event\DispatcherInterface;

\defined('_JEXEC') or die;

/**
 */
class BfCleanCart extends CMSPlugin
{
	protected $app;
	protected $autoloadLanguage = true;

	/*
	 */
	public function __construct(DispatcherInterface $dispatcher, array $config)
	{
		parent::__construct($dispatcher, $config);
	}

	/*
	 */
	public function onBeforeCartSave(&$element, &$do)
	{
		try
		{
			if ($this->isRobot())
			{
				throw new \Exception(Text::_('PLG_HIKASHOP_BFCLEANCART_ISROBOT'));
			}

			hikashop_cleanCart();
		}
		catch (\Exception $t)
		{
			$do = false;

			$element->messages ??= [];

			$message = $t->getMessage();
			if (in_array($message, $element->messages)) return;

			$cartClass = hikashop_get('class.cart');
			$cartClass->addMessage($element, array(
				'msg'  => $message,
				'type' => 'error'
			));
		}
	}

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

	/*
	 */
	protected function isRobot()
	{
		$browser = new Browser();
		if ($browser->isRobot()) return true;

	}
}