<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Subsystems;

// use JuniWalk\WHMCS\Enums\Sort;

trait UserSubsystem
{
	/**
	 * @param  string|null  $search
	 * @param  string  $sort
	 * @param  int  $offset
	 * @param  int  $limit
	 * @return string[]
	 */
	public function getUsers(
		string $search = null,
		string $sort = 'ASC',
		int $offset = 0,
		int $limit = 25
	): iterable {
		return $this->call('GetUsers', [
			'limitstart' => $offset,
			'limitnum' => $limit,
			'sorting' => $sort,
			'search' => $search,
		]);
	}
}
