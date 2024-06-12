<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\SubSystems;

use JuniWalk\Utils\Arrays;
use JuniWalk\WHMCS\Connector;	// ! Used for @phpstan
use JuniWalk\WHMCS\Entity\Client;
use JuniWalk\WHMCS\Entity\Domain;
use JuniWalk\WHMCS\Entity\Product;
use JuniWalk\WHMCS\Enums\ClientStatus;
use JuniWalk\WHMCS\Enums\Sort;
use JuniWalk\WHMCS\ItemIterator;
use Nette\Schema\Expect;

/**
 * @phpstan-import-type ResultList from Connector
 */
trait ClientSubSystem
{
	/**
	 * @return ItemIterator<Client>
	 * @see https://developers.whmcs.com/api-reference/getclients/
	 */
	public function getClients(
		?string $search = null,
		?ClientStatus $status = null,
		?string $orderBy = null,
		Sort $sort = Sort::ASC,
		int $offset = 0,
		int $limit = 25,
	): ItemIterator {
		/** @var ResultList */
		$response = $this->call('GetClients', [
			'search' => $search,
			'status' => $status?->name,
			'orderby' => $orderBy,
			'sorting' => $sort->name,
			'limitstart' => $offset,
			'limitnum' => $limit,
		]);

		/** @var Client[] */
		$items = Arrays::map(
			$response['clients']['client'] ?? [],	// @phpstan-ignore nullCoalesce.offset
			fn($x) => new Client($x),
		);

		/** @var ItemIterator<Client> */
		return (new ItemIterator($items))
			->setTotalResults($response['totalresults'])
			->setOffset($response['startnumber'] ?? 0)
			->setLimit($response['numreturned'] ?? 0);
	}


	/**
	 * @see https://developers.whmcs.com/api-reference/getclientsdetails/
	 */
	public function getClientsDetails(
		?int $clientId = null,
		?string $email = null,
		bool $stats = false,
	): Client {
		/** @var array{result: string, client: array<string, scalar>} */
		$response = $this->call('GetClientsDetails', [
			'clientid' => $clientId,
			'email' => $email,
			'stats' => $stats,
		]);

		return new Client($response['client']);
	}


	/**
	 * @param array{clientid?: ?int, domainid?: ?int, domain?: ?string} $params
	 * @return ItemIterator<Domain>
	 * @see https://developers.whmcs.com/api-reference/getclientsdomains/
	 */
	public function getClientsDomains(
		array $params,
		int $offset = 0,
		int $limit = 25,
	): ItemIterator {
		$params = $this->check($params, [
			'clientid'	=> Expect::int()->nullable(),
			'domainid'	=> Expect::int()->nullable(),
			'domain'	=> Expect::string()->nullable(),
		]);

		/** @var ResultList */
		$response = $this->call('GetClientsDomains', $params + [
			'limitstart' => $offset,
			'limitnum' => $limit,
		]);

		/** @var Domain[] */
		$items = Arrays::map(
			$response['domains']['domain'] ?? [],	// @phpstan-ignore nullCoalesce.offset
			fn($x) => new Domain($x),
		);

		/** @var ItemIterator<Domain> */
		return (new ItemIterator($items))
			->setTotalResults($response['totalresults'])
			->setOffset($response['startnumber'] ?? 0)
			->setLimit($response['numreturned'] ?? 0);
	}


	/**
	 * @param  array{clientid?: ?int, serviceid?: ?int, pid?: ?int, domain?: ?string, username2?: ?string} $params
	 * @return ItemIterator<Product>
	 * @see https://developers.whmcs.com/api-reference/getclientsproducts/
	 */
	public function getClientsProducts(
		array $params,
		int $offset = 0,
		int $limit = 25,
	): ItemIterator {
		$params = $this->check($params, [
			'clientid'	=> Expect::int()->nullable(),
			'serviceid'	=> Expect::int()->nullable(),
			'pid'		=> Expect::int()->nullable(),
			'domain'	=> Expect::string()->nullable(),
			'username2'	=> Expect::string()->nullable(),
		]);

		/** @var ResultList */
		$response = $this->call('GetClientsProducts', $params + [
			'limitstart' => $offset,
			'limitnum' => $limit,
		]);

		/** @var Product[] */
		$items = Arrays::map(
			$response['products']['product'] ?? [],	// @phpstan-ignore nullCoalesce.offset
			fn($x) => new Product($x),
		);

		/** @var ItemIterator<Product> */
		return (new ItemIterator($items))
			->setTotalResults($response['totalresults'])
			->setOffset($response['startnumber'] ?? 0)
			->setLimit($response['numreturned'] ?? 0);
	}
}
