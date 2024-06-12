<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2024
 * @license   MIT License
 */

use JuniWalk\WHMCS\Connector;
use Tester\Environment;
use Tracy\Debugger;

if (@!include __DIR__.'/../vendor/autoload.php') {
	echo 'Install Nette Tester using `composer install`';
	exit(1);
}

interface Config
{
	/**
	 * @param array<string, mixed> $params
	 */
	public function createConnector(array $params = []): Connector;
}

Debugger::enable(Debugger::Development);
Environment::setup();

function getConfig(): Config
{
	static $config = include 'config.php';

	if (!$config instanceof Config) {
		throw new Exception(basename(__DIR__).'/config.php should return '.Config::class.' instance');
	}

	return $config;
}
