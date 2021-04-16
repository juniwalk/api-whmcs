<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2021
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Subsystems;

use JuniWalk\WHMCS\Entity\CustomField;
use JuniWalk\WHMCS\Entity\CustomFieldValue;

trait CustomFieldsSubsystem
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
	 * @return CustomField
	 * @throws NoResultException
	 */
	public function getFieldValue(int $fieldId): CustomFieldValue
	{
		$builder = $this->createQueryBuilder(CustomFieldValue::class, 'e')
			->where('e.fieldid = :fieldId')
			->setParameter('fieldId', $fieldId);

		$result = $builder->execute();

		if (!$result->rowCount()) {
			throw NoResultException::fromClass(CustomFieldValue::class, $id);
		}

		return CustomFieldValue::fromResult($result->fetchAssociative());
	}


	/**
	 * @param  string  $productId
	 * @param  callable|null  $where
	 * @return CustomField|null
	 */
	public function findFieldByProduct(int $productId, callable $where = null): ?CustomField
	{
		$items = [];
		$builder = $this->createQueryBuilder(CustomField::class, 'e')
			->where('e.relid = :productId')
			->setParameter('productId', $productId)
			->setMaxResults(1);

		if (is_callable($where)) {
			$builder = $where($builder) ?: $builder;
		}

		$result = $builder->execute();

		if (!$result->rowCount()) {
			return null;
		}

		return CustomField::fromResult($result->fetchAssociative());
	}
}
