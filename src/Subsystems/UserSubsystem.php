<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Subsystems;

use JuniWalk\WHMCS\Enums\Sort;
use JuniWalk\WHMCS\Tools\ItemIterator;

trait UserSubsystem
{
	/**
	 * @param  string|null  $search
	 * @param  string  $sort
	 * @param  int  $offset
	 * @param  int  $limit
	 * @return string[]
	 * @see https://developers.whmcs.com/api-reference/getusers/
	 */
	public function getUsers(
		string $search = null,
		Sort $sort = Sort::ASC,
		int $offset = 0,
		int $limit = 25
	): ItemIterator {
		$data = $this->call('GetUsers', [
			'limitstart' => $offset,
			'limitnum' => $limit,
			'sorting' => $sort->name,
			'search' => $search,
		]);

		$items = new ItemIterator($data['users'] ?? []);
		$items->setTotalResults($data['totalresults']);
		$items->setOffset($data['startnumber']);
		$items->setLimit($data['numreturned']);
		return $items;
	}
}
