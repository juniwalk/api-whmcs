<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Subsystems;

use JuniWalk\WHMCS\Tools\ItemIterator;

trait OrderSubsystem
{
	/**
	 * @param  string $productId
	 * @param  string|null  $module
	 * @param  int|null  $groupId
	 * @return string[]
	 * @see https://developers.whmcs.com/api-reference/getproducts/
	 */
	public function getProducts(
		string $productId = '',
		int $groupId = null,
		string $module = null
	): ItemIterator {
		$data = $this->call('GetProducts', [
			'pid' => $productId,
			'gid' => $groupId,
			'module' => $module,
		]);

		$items = new ItemIterator($data['products']['product']);
		$items->setTotalResults($data['totalresults']);
		$items->setOffset($data['startnumber']);
		$items->setLimit($data['numreturned']);
		return $items;
	}
}
