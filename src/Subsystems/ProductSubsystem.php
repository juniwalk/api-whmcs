<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2021
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Subsystems;

use JuniWalk\WHMCS\Entity\Product;

trait ProductSubsystem
{
	/**
	 * @param  int  $productId
	 * @return Product
	 */
	public function getProduct(int $productId): Product
	{
		$query = $this->createQueryBuilder(Product::class, 'p')
			->where('p.id = :productId')
			->setParameter('productId', $productId);

		$result = $query->execute();

		return Product::fromResult($result);
	}
}
