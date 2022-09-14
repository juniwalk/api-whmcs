<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Subsystems;

use JuniWalk\WHMCS\Enums\ClientStatus;
use JuniWalk\WHMCS\Enums\Sort;
use JuniWalk\WHMCS\Tools\ItemIterator;
use Nette\Schema\Expect;

trait ClientSubsystem
{
	/**
	 * @see https://developers.whmcs.com/api-reference/getclients/
	 */
	public function getClients(
		string $search = null,
		ClientStatus $status = null,
		string $orderBy = null,
		Sort $sort = Sort::ASC,
		int $offset = 0,
		int $limit = 25
	): ItemIterator {
		$data = $this->call('GetClients', [
			'search' => $search,
			'status' => $status->name,
			'orderby' => $orderBy,
			'sorting' => $sort->name,
			'limitstart' => $offset,
			'limitnum' => $limit,
		]);

		$items = new ItemIterator($data['clients']['client']);
		$items->setTotalResults($data['totalresults']);
		$items->setOffset($data['startnumber'] ?? 0);
		$items->setLimit($data['numreturned'] ?? 0);
		return $items;
	}


	/**
	 * @see https://developers.whmcs.com/api-reference/getclientsdomains/
	 */
	public function getClientsDomains(
		iterable $params,
		int $offset = 0,
		int $limit = 25
	): ItemIterator
	{
		$params = $this->check($params, [
			'clientid'	=> Expect::int()->nullable(),
			'domainid'	=> Expect::int()->nullable(),
			'domain'	=> Expect::string()->nullable(),
		]);

		$data = $this->call('GetClientsDomains', $params + [
			'limitstart' => $offset,
			'limitnum' => $limit,
		]);

		$items = new ItemIterator($data['domains']['domain']);
		$items->setTotalResults($data['totalresults']);
		$items->setOffset($data['startnumber']);
		$items->setLimit($data['numreturned']);
		return $items;
	}
}
