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
}
