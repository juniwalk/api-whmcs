<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2024
 * @license   MIT License
 */

use JuniWalk\WHMCS\Enums\DomainStatus as Status;
use Tester\Assert;
use Tester\TestCase;

require __DIR__.'/../bootstrap.php';

/**
 * @testCase
 */
final class ProductTest extends TestCase
{
	public function setUp() {}
	public function tearDown() {}

	public function testGetProductsInvalid(): void
	{
		$whmcs = getConfig()->createConnector();
		$items = $whmcs->getProductsInvalid();

		foreach ($items as $product) {
			if ($product->getClientId() <> 13) {
				continue;
			}

			Assert::same($product->getGroupName(), 'Webhosting');
			Assert::same($product->getStatus(), Status::Active);
		}
	}
}

(new ProductTest)->run();
