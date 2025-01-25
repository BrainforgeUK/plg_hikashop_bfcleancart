<?php
/**
 * @package    Enhanced Hikashop cart cleaner.
 * @author     https://www.brainforge.co.uk
 * @copyright  (C) 2025 Jonathan Brain. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Brainforgeuk\Plugin\Hikashop\BfCleanCart\Extension;

use Brainforgeuk\Plugin\Hikashop\BfCleanCart\Traits\CartTrait;
use Brainforgeuk\Plugin\Hikashop\BfCleanCart\Traits\OrderTrait;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Event\DispatcherInterface;

\defined('_JEXEC') or die;

/**
 */
class BfCleanCart extends CMSPlugin
{
	use CartTrait;
	use OrderTrait;

	protected   $app;
	protected   $autoloadLanguage = true;
	public      $params;

	/*
	 */
	public function __construct(DispatcherInterface $dispatcher, array $config)
	{
		parent::__construct($dispatcher, $config);
	}
}