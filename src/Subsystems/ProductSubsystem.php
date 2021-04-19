<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2021
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Subsystems;

use JuniWalk\WHMCS\Entity\Hosting;
use JuniWalk\WHMCS\Entity\Product;

trait ProductSubsystem
{
	/**
	 * @param  int  $productId
	 * @return Product
	 */
	public function getProduct(int $productId): Product
	{
		return $this->getOneById($productId, Product::class);
	}


	/**
	 * @param  int  $productId
	 * @return Product|null
	 */
	public function findProduct(int $productId): ?Product
	{
		return $this->findOneById($productId, Product::class);
	}


	/**
	 * @param  int  $userId
	 * @param  int  $productGroupId
	 * @return Product|null
	 */
	public function findActiveDiskExpansion(int $userId, int $productGroupId): ?Product
	{
		return $this->findOneBy(Product::class, function($qb) use ($userId, $productGroupId) {
			$qb->innerJoin('e', Hosting::TABLE_NAME, 'h', 'h.packageid = e.id');
			$qb->where('e.gid = :group AND e.type = :type AND h.domainstatus = :status AND h.userid = :user');
			$qb->setParameter('group', $productGroupId);
			$qb->setParameter('status', 'Active');
			$qb->setParameter('user', $userId);
			$qb->setParameter('type', 'other');
		});
	}
}
