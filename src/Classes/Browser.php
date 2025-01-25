<?php
/**
 * @package   Component for creating personalised public transport timetables
 * @version   0.0.1
 * @author    https://www.brainforge.co.uk
 * @copyright Copyright (C) 2021 Jonathan Brain. All rights reserved.
 * @license   GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Brainforgeuk\Plugin\Hikashop\BfCleanCart\Classes;

use Joomla\CMS\Environment\Browser as JoomlaBrowser;
use Joomla\Utilities\IpHelper;

\defined('_JEXEC') or die;

class Browser extends JoomlaBrowser
{
	protected $robotIPS = [
	];

	/*
	 */
	public function __construct($userAgent = null, $accept = null)
	{
		parent::__construct($userAgent, $accept);

		$this->robots = array_merge($this->robots,
			[
				'Amazonbot',
				'Bytespider',
				'ClaudeBot',
				'gptbot',
				'Google-Read-Aloud',
				'meta-externalagent',
				'PetalBot',
				'SemrushBot',
			]
			);
	}

	/*
	 */
	public function isRobot()
	{
		if (!empty($this->robotIPS))
		{
			$ip = IpHelper::getIp();

			foreach($this->robotIPS as $ignoredIp)
			{
				if (str_starts_with($ip, $ignoredIp)) return true;
			}
		}

		return parent::isRobot();
	}

	/*
	 */
	public function addUserAgents($userAgents)
	{
		foreach(preg_split('/\n+', $userAgents) as $userAgent)
		{
			$userAgent = trim($userAgent);
			if (empty($userAgent)) continue;
			if ($userAgent[0] == '#') continue;

			$this->$userAgent[] = $userAgent;
		}
	}

	/*
	 */
	public function addRobotIPs($robotIPs)
	{
		foreach(preg_split('/\n+', $robotIPs) as $robotIP)
		{
			$robotIP = trim($robotIP);
			if (empty($robotIP)) continue;
			if ($robotIP[0] == '#') continue;

			$this->robotIPS[] = $robotIP;
		}
	}
}
