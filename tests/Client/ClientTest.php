<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2024
 * @license   MIT License
 */

use Tester\Assert;
use Tester\TestCase;

require __DIR__.'/../bootstrap.php';

/**
 * @testCase
 */
final class ClientTest extends TestCase
{
	const Username = 'Martin Procházka';

	public function setUp() {}
	public function tearDown() {}

	public function testGetClients(): void
	{
		$whmcs = getConfig()->createConnector();
		$items = $whmcs->getClients(search: static::Username);

		Assert::same($items[0]?->getFullName(), static::Username);
		Assert::null($items[0]?->getCurrency());
	}

	public function testGetClientsDetails(): void
	{
		$whmcs = getConfig()->createConnector();
		$item = $whmcs->getClientsDetails(clientId: 425);

		Assert::same($item->getFullName(), static::Username);
		Assert::same($item->getCurrency(), 1);
		Assert::null($item->getDateCreated());
	}
}

(new ClientTest)->run();
