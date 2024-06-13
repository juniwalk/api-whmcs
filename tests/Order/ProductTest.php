<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2024
 * @license   MIT License
 */

use JuniWalk\WHMCS\Enums\InvoiceStatus as Status;
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

	public function testGetProducts(): void
	{
		$whmcs = getConfig()->createConnector();
		$items = $whmcs->getProducts(productId: 139);

		Assert::same($items[0]?->getType(), 'other');
		Assert::same($items[0]?->getPackageId(), 139);
		// Assert::null($items[0]?->getGroupName());	// TODO: Uncomment when iterating over properties in AbstractEntity is implemented
	}
}

(new ProductTest)->run();
