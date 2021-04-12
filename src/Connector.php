<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2021
 * @license   MIT License
 */

namespace JuniWalk\WHMCS;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class Connector
{
	use Subsystems\Client;

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
}
