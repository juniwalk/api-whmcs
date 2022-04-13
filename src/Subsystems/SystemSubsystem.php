<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Subsystems;

use JuniWalk\WHMCS\Tools\ItemIterator;

trait SystemSubsystem
{
	/**
	 * @param  string $productId
	 * @param  string|null  $module
	 * @param  int|null  $groupId
	 * @return string[]
	 * @see https://developers.whmcs.com/api-reference/getcurrencies/
	 */
	public function getCurrencies(): ItemIterator
	{
		$data = $this->call('GetCurrencies');

		$items = new ItemIterator($data['currencies']);
		$items->setTotalResults($data['totalresults']);
		$items->setOffset($data['startnumber'] ?? 0);
		$items->setLimit($data['numreturned'] ?? 0);
		return $items;
	}
}
