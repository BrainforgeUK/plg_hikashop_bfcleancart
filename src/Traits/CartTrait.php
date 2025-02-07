<?php
/**
 * @package    Enhanced Hikashop cart cleaner.
 * @author     https://www.brainforge.co.uk
 * @copyright  (C) 2025 Jonathan Brain. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Brainforgeuk\Plugin\Hikashop\BfCleanCart\Traits;

use Brainforgeuk\Plugin\Hikashop\BfCleanCart\Classes\Browser;
use Joomla\CMS\Language\Text;

\defined('_JEXEC') or die;

/**
 */
Trait CartTrait
{
	/*
	 */
	public function onBeforeCartSave(&$element, &$do)
	{
		try
		{
			$checkForRobot = $this->params->get('checkforrobot', 0);
			if ($checkForRobot)
			{
				$this->isRobot($checkForRobot);
			}

			if ($this->params->get('cleancart', 0))
			{
				hikashop_cleanCart();
			}
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

	/*
	 */
	protected function isRobot($checkForRobot, $throw=true)
	{
		$user = $this->app->getIdentity();
		if ($user->id) return false;

		$browser = new Browser();
		$browser->addRobotIPs($this->params->get('robotips'));
		$browser->addUserAgents($this->params->get('useragents'));
		$browser->setCheckForRobot($checkForRobot);

		if (!$browser->isRobot()) return false;

		if (!$throw) return true;

		throw new \Exception(Text::_('PLG_HIKASHOP_BFCLEANCART_ISROBOT'));
	}
}