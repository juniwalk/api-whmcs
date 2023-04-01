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
			'status' => $status?->name,
			'orderby' => $orderBy,
			'sorting' => $sort->name,
			'limitstart' => $offset,
			'limitnum' => $limit,
		]);

		$items = new ItemIterator($data['clients']['client'] ?? []);
		$items->setTotalResults($data['totalresults']);
		$items->setOffset($data['startnumber'] ?? 0);
		$items->setLimit($data['numreturned'] ?? 0);
		return $items;
	}


	/**
	 * @see https://developers.whmcs.com/api-reference/getclientsdetails/
	 * @deprecated
	 */
	public function getClientsDetails(?int $clientId, ?string $email, bool $stats = false): array
	{
		return $this->call('GetClientsDetails', [
			'clientid' => $clientId,
			'email' => $email,
			'stats' => $stats,
		]);
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

		$items = new ItemIterator($data['domains']['domain'] ?? []);
		$items->setTotalResults($data['totalresults']);
		$items->setOffset($data['startnumber']);
		$items->setLimit($data['numreturned']);
		return $items;
	}


	/**
	 * @see https://developers.whmcs.com/api-reference/getclientsproducts/
	 */
	public function getClientsProducts(
		iterable $params,
		int $offset = 0,
		int $limit = 25
	): ItemIterator
	{
		$params = $this->check($params, [
			'clientid'	=> Expect::int()->nullable(),
			'serviceid'	=> Expect::int()->nullable(),
			'pid'		=> Expect::int()->nullable(),
			'domain'	=> Expect::string()->nullable(),
			'username2'	=> Expect::string()->nullable(),
		]);

		$data = $this->call('GetClientsProducts', $params + [
			'limitstart' => $offset,
			'limitnum' => $limit,
		]);

		$items = new ItemIterator($data['products']['product'] ?? []);
		$items->setTotalResults($data['totalresults']);
		$items->setOffset($data['startnumber']);
		$items->setLimit($data['numreturned']);
		return $items;
	}
}
