<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2021
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Subsystems;

use JuniWalk\WHMCS\Entity\Client;

trait ClientSubsystem
{
	/**
	 * @param  int  $clientId
	 * @return Client
	 */
	public function getClient(int $clientId): Client
	{
		return $this->getOneById($clientId, Client::class);
	}


	/**
	 * @param  int  $clientId
	 * @return Client|null
	 */
	public function findClient(int $clientId): ?Client
	{
		return $this->findOneById($clientId, Client::class);
	}


	/**
	 * @param  int[]  $clientIds
	 * @return Client[]
	 */
	public function findClients(iterable $clientIds): iterable
	{
		$clientIds = array_unique($clientIds);
		$clientIds = implode(',', $clientIds);

		return $this->getBy(Client::class, function($qb) use ($clientIds) {
			$qb->where($qb->expr()->in('e.id', $clientIds));
		});
	}


	/**
	 * @param  string  $query
	 * @param  callable|null  $where
	 * @return Client[]
	 */
	public function findCliendByName(string $query, callable $where = null): iterable
	{
		return $this->findBy(Client::class, function($qb) use ($query, $where) {
			$qb->orWhere('e.firstname LIKE :query');
			$qb->orWhere('e.lastname LIKE :query');
			$qb->orWhere('e.companyname LIKE :query');
			$qb->setParameter('query', "%{$query}%");

			if (is_callable($where)) {
				$qb = $where($qb) ?: $qb;
			}
		});
	}
}
