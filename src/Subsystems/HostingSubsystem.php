<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2021
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Subsystems;

use JuniWalk\WHMCS\Entity\Hosting;
use JuniWalk\WHMCS\Entity\Product;

trait HostingSubsystem
{
	/**
	 * @param  int  $hostingId
	 * @return Hosting
	 */
	public function getHosting(int $hostingId): Hosting
	{
		return $this->getOneById($hostingId, Hosting::class);
	}


	/**
	 * @param  int  $hostingId
	 * @return Hosting|null
	 */
	public function findHosting(int $hostingId): ?Hosting
	{
		return $this->findOneById($hostingId, Hosting::class);
	}


	/**
	 * @param  string  $query
	 * @param  callable|null  $where
	 * @return Hosting[]
	 */
	public function findActiveHostings(): iterable
	{
		$items = [];
		$builder = $this->createQueryBuilder(Hosting::class, 'e')
			->innerJoin('e', Product::TABLE_NAME, 'p', 'e.packageid = p.id')
			->where('e.domainstatus = :status AND p.type = :type')
			->setParameter('status', 'Active')
			->setParameter('type', 'hostingaccount');

		if (!$result = $builder->execute()) {
			return $items;
		}

		foreach ($result->fetchAllAssociative() as $item) {
			$item = Hosting::fromResult($item);
			$items[$item->getId()] = $item;
		}

		return $items;
	}
}
