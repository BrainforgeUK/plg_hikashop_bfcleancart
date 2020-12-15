<?php
/**
 * @package    Hikashop Plugin to clean cart when order completed by BrainforgeUK
 * @author     https://www.brainforge.co.uk
 * @copyright  (C) 2020 Jonathan Brain. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\CMSPlugin;

class plgHikashopBfcleancart extends CMSPlugin
{
	/**
	 * Constructor
	 *
	 * @param   object  &$subject  The object to observe
	 * @param   array   $config    An optional associative array of configuration settings.
	 *                             Recognized key values include 'name', 'group', 'params', 'language'
	 *                             (this list is not meant to be comprehensive).
	 *
	 * @since   1.5
	 */
	public function __construct(&$subject, $config) {
		parent::__construct($subject, $config);

		$this->app = Factory::getApplication();
		$language = Factory::getLanguage();
		$language->load('plg_hikashop_bfcleancart', __DIR__);
	}

	/**
	 */
	public function onAfterOrderCreate(&$order, &$send_email)
	{
		$this->cleanCart($order);
	}

	/**
	 */
	public function onAfterOrderUpdate(&$order, &$send_email)
	{
		$this->cleanCart($order);
	}

	/**
	 */
	protected function cleanCart(&$order)
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
