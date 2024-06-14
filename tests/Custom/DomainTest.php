<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2024
 * @license   MIT License
 */

use JuniWalk\WHMCS\Enums\DomainStatus;
use Tester\Assert;
use Tester\TestCase;

require __DIR__.'/../bootstrap.php';

/**
 * @testCase
 */
final class DomainTest extends TestCase
{
	public function setUp() {}
	public function tearDown() {}

	public function testGetDomainsInvalid(): void
	{
		$whmcs = getConfig()->createConnector();
		$items = $whmcs->getDomainsInvalid();

		foreach ($items as $domain) {
			if ($domain->getUserId() <> 166) {
				continue;
			}

			Assert::same($domain->getRegPeriod(), 100);
			Assert::same($domain->getStatus(), DomainStatus::Active);
		}
	}
}

(new DomainTest)->run();
