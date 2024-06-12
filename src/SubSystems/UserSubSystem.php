<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\SubSystems;

use JuniWalk\Utils\Arrays;
use JuniWalk\WHMCS\Connector;	// ! Used for @phpstan
use JuniWalk\WHMCS\Entity\User;
use JuniWalk\WHMCS\Enums\Sort;
use JuniWalk\WHMCS\ItemIterator;

/**
 * @phpstan-import-type ResultList from Connector
 */
trait UserSubSystem
{
	/**
	 * @return ItemIterator<User>
	 * @see https://developers.whmcs.com/api-reference/getusers/
	 */
	public function getUsers(
		?string $search = null,
		Sort $sort = Sort::ASC,
		int $offset = 0,
		int $limit = 25,
	): ItemIterator {
		/** @var ResultList */
		$response = $this->call('GetUsers', [
			'limitstart' => $offset,
			'limitnum' => $limit,
			'sorting' => $sort->name,
			'search' => $search,
		]);

		/** @var User[] */
		$items = Arrays::map(
			$response['users'] ?? [],		// @phpstan-ignore nullCoalesce.offset
			fn($x) => new User($x),
		);

		/** @var ItemIterator<User> */
		return (new ItemIterator($items))
			->setTotalResults($response['totalresults'])
			->setOffset($response['startnumber'] ?? 0)
			->setLimit($response['numreturned'] ?? 0);
	}
}
