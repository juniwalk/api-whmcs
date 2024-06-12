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
final class UserTest extends TestCase
{
	const Username = 'Martin Procházka';

	public function setUp() {}
	public function tearDown() {}

	public function testGetUsers(): void
	{
		$whmcs = getConfig()->createConnector();
		$items = $whmcs->getUsers(static::Username);

		Assert::same($items[0]?->getFullName(), static::Username);
	}
}

(new UserTest)->run();
