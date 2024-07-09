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
	const DomainName = 'dveplusdve.cz';

	public function setUp() {}
	public function tearDown() {}

	public function testProduct(): void
	{
		$whmcs = getConfig()->createConnector();

		if (!$item = $whmcs->getHostingByDomain(self::DomainName)) {
			Assert::true(true);	// If product is not found
			return;
		}

		$diskLimit = $whmcs->findDiskLimitByDomain(self::DomainName) ?? 0;
		$diskUsage = mt_rand(0, $diskLimit);

		try {
			$item->setDiskLimit($diskLimit);
			$item->setDiskUsage($diskUsage);

			$whmcs->updateClientProduct($item);

		} catch (Throwable) {
			Assert::fail('Unable to update hosting');
		}

		Assert::same($item->isDiskOverLimit(), $diskUsage >= $diskLimit);
		Assert::same($item->getDiskLimit(), $diskLimit);
		Assert::same($item->getDiskUsage(), $diskUsage);
	}

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

		Assert::true(true);	// If there are no invalid products
	}
}

(new ProductTest)->run();
