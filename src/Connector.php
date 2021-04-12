<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2021
 * @license   MIT License
 */

namespace JuniWalk\WHMCS;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Query\QueryBuilder;
use Nette\Utils\Strings;

class Connector
{
	use Subsystems\ClientSubsystem;

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
	 * @param  string  $tableName
	 * @param  string  $alias
	 * @return QueryBuilder
	 */
	protected function createQueryBuilder(string $className, string $alias): QueryBuilder
	{
		$query = $this->db->createQueryBuilder()->from($className::TABLE_NAME, $alias);

		foreach ($className::listColumns() as $column => $value) {
			$query->addSelect($alias.'.'.$column);
		}

		return $query;
	}
}
