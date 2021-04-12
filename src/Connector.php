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
	use Subsystems\Client;

	/** @var string */
	const TABLE_PREFIX = 'tbl';

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
	 * @param  bool  $autoPrefix
	 * @return QueryBuilder
	 */
	protected function createQueryBuilder(string $tableName, string $alias, bool $autoPrefix = true): QueryBuilder
	{
		if ($autoPrefix && !Strings::startsWith($tableName, $this::TABLE_PREFIX)) {
			$tableName = $this::TABLE_PREFIX.$tableName;
		}

		return $this->db->createQueryBuilder()
			->select($alias.'.*')
			->from($tableName, $alias);
	}
}
