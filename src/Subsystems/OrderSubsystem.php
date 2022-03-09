<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Subsystems;

trait OrderSubsystem
{
	/**
	 * @param  string $productId
	 * @param  string|null  $module
	 * @param  int|null  $groupId
	 * @return string[]
	 */
	public function getProducts(
		string $productId,
		int $groupId = null,
		string $module = null
	): iterable {
		return $this->call('GetProducts', [
			'pid' => $productId,
			'gid' => $groupId,
			'module' => $module,
		]);
	}
}
