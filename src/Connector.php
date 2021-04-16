<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2021
 * @license   MIT License
 */

namespace JuniWalk\WHMCS;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use JuniWalk\WHMCS\Entity\AbstractEntity;
use JuniWalk\WHMCS\Exceptions\InvalidEntityException;
use JuniWalk\WHMCS\Exceptions\NoResultException;
use Nette\Utils\Strings;

class Connector
{
	use Subsystems\ClientSubsystem;
	use Subsystems\CustomFieldsSubsystem;
	use Subsystems\HostingSubsystem;
	use Subsystems\ProductSubsystem;

	/** @var Connection */
	private $database;


	/**
	 * @param  Connection  $database
	 */
	public function __construct(Connection $database)
	{
		$this->database = $database;
	}


	/**
	 * @param  AbstractEntity  $entity
	 * @return void
	 */
	public function persist(AbstractEntity $entity): void
	{
		if (!$changes = $entity::listChanges($entity)) {
			return;
		}

		$query = $this->database->createQueryBuilder()
			->update($entity::TABLE_NAME, 'e');

		foreach ($changes as $key => $value) {
			$query->set('e.'.$key, ':'.$key);
			$query->setParameter($key, $value);
		}

		$query->where('e.id = :id')->setParameter('id', $entity->getId());
		$query->execute();
	}


	/**
	 * @param  int  $id
	 * @param  string  $className
	 * @return AbstractEntity
	 * @throws NoResultException
	 */
	public function getOneById(int $id, string $className): AbstractEntity
	{
		$query = $this->createQueryBuilder($className, 'e')
			->where('e.id = :id')
			->setParameter('id', $id)
			->setMaxResults(1);

		$result = $query->execute();

		if (!$result->rowCount()) {
			throw NoResultException::fromClass($className, $id);
		}

		return $className::fromResult($result->fetchAssociative());
	}


	/**
	 * @param  int  $id
	 * @param  string  $className
	 * @return AbstractEntity|null
	 */
	public function findOneById(int $id, string $className): ?AbstractEntity
	{
		try {
			return $this->getOneById($id, $className);

		} catch (NoResultException $e) {
		}

		return null;
	}


	/**
	 * @param  string  $tableName
	 * @param  string  $alias
	 * @return QueryBuilder
	 * @throws InvalidEntityException
	 */
	protected function createQueryBuilder(string $className, string $alias): QueryBuilder
	{
		if (!is_subclass_of($className, AbstractEntity::class)) {
			throw InvalidEntityException::fromClass($className);
		}

		$query = $this->database->createQueryBuilder()
			->from($className::TABLE_NAME, $alias);

		foreach ($className::listColumns() as $column => $value) {
			$query->addSelect($alias.'.'.$column);
		}

		return $query;
	}
}
