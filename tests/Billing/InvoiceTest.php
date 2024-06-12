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
final class InvoiceTest extends TestCase
{
	public function setUp() {}
	public function tearDown() {}

	public function testGetInvoice(): void
	{
		$whmcs = getConfig()->createConnector();
		$item = $whmcs->getInvoice(invoiceId: 120220707);

		Assert::same($item->getStatus(), Status::Paid);
		Assert::same($item->getTotal(), 175.45);
	}

	public function testGetInvoices(): void
	{
		$whmcs = getConfig()->createConnector();
		$items = $whmcs->getInvoices(userId: 413);

		foreach ($items as $item) {
			if ($item->getId() <> 120220707) {
				continue;
			}

			Assert::same($item->getStatus(), Status::Paid);
			Assert::same($item->getTotal(), 175.45);
		}
	}
}

(new InvoiceTest)->run();
