<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2021
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Subsystems;

use JuniWalk\WHMCS\Entity\CustomField;
use JuniWalk\WHMCS\Entity\CustomFieldValue;

trait FieldSubsystem
{
	/**
	 * @param  int  $fieldId
	 * @return CustomField
	 */
	public function getField(int $fieldId): CustomField
	{
		return $this->getOneById($fieldId, CustomField::class);
	}


	/**
	 * @param  int  $fieldId
	 * @return CustomField|null
	 */
	public function findField(int $fieldId): ?CustomField
	{
		return $this->findOneById($fieldId, CustomField::class);
	}


	/**
	 * @param  int  $fieldId
	 * @return CustomFieldValue
	 */
	public function getFieldValue(int $fieldId): CustomFieldValue
	{
		return $this->findOneBy(CustomFieldValue::class, function($qb) use ($fieldId) {
			$qb->where('e.fieldid = :fieldId');
			$qb->setParameter('fieldId', $fieldId);
		});
	}


	/**
	 * @param  string  $productId
	 * @param  callable|null  $where
	 * @return CustomField|null
	 */
	public function findFieldByProduct(int $productId, callable $where = null): ?CustomField
	{
		return $this->findOneBy(CustomField::class, function($qb) use ($productId, $where) {
			$qb->where('e.relid = :productId');
			$qb->setParameter('productId', $productId);

			if (is_callable($where)) {
				$qb = $where($qb) ?: $qb;
			}
		});
	}
}
