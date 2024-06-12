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
final class TransactionTest extends TestCase
{
	public function setUp() {}
	public function tearDown() {}

	public function testGetTransactions(): void
	{
		$whmcs = getConfig()->createConnector();
		$items = $whmcs->getTransactions(invoiceId: 120220707);

		dump($items);

		Assert::same($items[0]?->getAmountIn(), 175.45);
		Assert::same($items[0]?->getAmountOut(), 0.0);
	}
}

(new TransactionTest)->run();
