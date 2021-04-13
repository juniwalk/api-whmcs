<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2021
 * @license   MIT License
 */

namespace JuniWalk\WHMCS;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Query\QueryBuilder;
use JuniWalk\WHMCS\Entity\AbstractEntity;
use Nette\Utils\Strings;

class Connector
{
	use Subsystems\ClientSubsystem;
	use Subsystems\ProductSubsystem;

	/** @var Connection */
	private $db;


	/**
	 * @param  string  $connectionUrl
	 */
	public function __construct(string $connectionUrl)
	{
		$this->db = DriverManager::getConnection([
			'url' => $connectionUrl,
		]);
	}


	/**
	 * @param  int  $id
	 * @param  string  $className
	 * @return AbstractEntity
	 * @throws Exception
	 */
	public function getOneById(int $id, string $className): AbstractEntity
	{
		$query = $this->createQueryBuilder($className, 'e')
			->where('e.id = :id')
			->setParameter('id', $id);

		$result = $query->execute();

		return $className::fromResult($result);
	}


	/**
	 * @param  int  $id
	 * @param  string  $className
	 * @return AbstractEntity|null
	 */
	public function findOneById(int $id, string $className): ?AbstractEntity
	{
		return null;
		// return $this->getOneById($id, $className) ?: null;
	}


	/**
	 * @param  string  $tableName
	 * @param  string  $alias
	 * @return QueryBuilder
	 * @throws Exception
	 */
	protected function createQueryBuilder(string $className, string $alias): QueryBuilder
	{
		if (!is_subclass_of($className, AbstractEntity::class)) {
			throw new \Exception;
		}

		$query = $this->db->createQueryBuilder()->from($className::TABLE_NAME, $alias);

		foreach ($className::listColumns() as $column => $value) {
			$query->addSelect($alias.'.'.$column);
		}

		return $query;
	}
}
