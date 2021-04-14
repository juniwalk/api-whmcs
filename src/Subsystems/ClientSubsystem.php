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
	 * @param  string  $query
	 * @param  callable|null  $where
	 * @return Client[]
	 */
	public function findCliendByName(string $query, callable $where = null): iterable
	{
		$items = [];
		$builder = $this->createQueryBuilder(Client::class, 'e')
			->where('e.firstname LIKE :query OR e.lastname LIKE :query OR e.companyname LIKE :query')
			->setParameter('query', "%{$query}%");

		if (is_callable($where)) {
			$builder = $where($builder) ?: $builder;
		}

		if (!$result = $builder->execute()) {
			return $items;
		}

		foreach ($result->fetchAllAssociative() as $item) {
			$item = Client::fromResult($item);
			$items[$item->getId()] = $item;
		}

		return $items;
	}
}
