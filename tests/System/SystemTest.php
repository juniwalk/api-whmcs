<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2024
 * @license   MIT License
 */

use JuniWalk\Utils\Enums\Currency;
use Tester\Assert;
use Tester\TestCase;

require __DIR__.'/../bootstrap.php';

/**
 * @testCase
 */
final class SystemTest extends TestCase
{
	public function setUp() {}
	public function tearDown() {}

	public function testGetCurrencies(): void
	{
		$whmcs = getConfig()->createConnector();
		$items = $whmcs->getCurrencies();

		foreach ($items as $item) {
			Assert::contains($item->getCode(), ['CZK', 'EUR']);
			Assert::type(Currency::class, $item->getEnum());
		}
	}
}

(new SystemTest)->run();
