<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Subsystems;

// use JuniWalk\WHMCS\Enums\Sort;

trait OrderSubsystem
{
	/**
	 * @param  string|null  $module
	 * @param  int|null  $groupId
	 * @param  int ... $productId
	 * @return string[]
	 */
	public function getProducts(
		string $module = null,
		int $groupId = null,
		int ... $productId
	): iterable {
		return $this->call('GetProducts', [
			'pid' => implode(',', $productId),
			'gid' => $groupId,
			'module' => $module,
		]);
	}
}
