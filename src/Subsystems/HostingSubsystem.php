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
	 * @return Hosting[]
	 */
	public function findActiveHostings(): iterable
	{
		return $this->findBy(Hosting::class, function($qb) {
			$qb->innerJoin('e', Product::TABLE_NAME, 'p', 'e.packageid = p.id');
			$qb->where('e.domainstatus = :status AND p.type = :type');
			$qb->setParameter('type', 'hostingaccount');
			$qb->setParameter('status', 'Active');
		});
	}
}
