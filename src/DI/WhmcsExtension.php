<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2021
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\DI;

use Doctrine\DBAL\DriverManager;
use JuniWalk\WHMCS\Connector;
use Nette\DI\CompilerExtension;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

final class WhmcsExtension extends CompilerExtension
{
	/**
	 * @return Schema
	 */
	public function getConfigSchema(): Schema
	{
		return Expect::structure([
			'dbname' => Expect::string()->required(),
			'user' => Expect::string()->required(),
			'password' => Expect::string()->required(),
			'host' => Expect::string('localhost'),
			'port' => Expect::int(),
			'driver' => Expect::string('pdo_mysql'),
			'charset' => Expect::string(),
		])

		->castTo('array');
	}


	/**
	 * @return void
	 */
	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$config = $this->getConfig();

		$builder->addDefinition($this->prefix('database'))
			->setFactory(DriverManager::class.'::getConnection', [$config])
			->setAutowired(false);

		$builder->addDefinition($this->prefix('connector'))
			->setFactory(Connector::class, ['@'.$this->prefix('database')]);
	}
}
