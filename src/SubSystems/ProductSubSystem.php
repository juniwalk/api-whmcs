<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2024
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\SubSystems;

use JuniWalk\Utils\Arrays;
use JuniWalk\WHMCS\Connector;	// ! Used for @phpstan
use JuniWalk\WHMCS\Entity\Product;
use JuniWalk\WHMCS\ItemIterator;
use Nette\Schema\Expect;

/**
 * @phpstan-import-type ResultList from Connector
 */
trait ProductSubSystem
{
	/**
	 * Custom API call
	 */
	public function getHostingByDomain(string $domainName): ?Product
	{
		/** @var array{result: string, product?: array<string, ?scalar>} */
		$response = $this->call('GetHostingByDomain', [
			'domain' => $domainName,
		]);

		if (!isset($response['product'])) {
			return null;
		}

		return new Product($response['product']);
	}


	/**
	 * Custom API call
	 */
	public function findDiskLimitByDomain(string $domainName): ?int
	{
		/** @var array{result: string, diskLimit?: int} */
		$response = $this->call('FindDiskLimitByDomain', [
			'domain' => $domainName,
		]);

		return $response['diskLimit'] ?? null;
	}


	/**
	 * @see https://developers.whmcs.com/api-reference/updateclientproduct/
	 */
	public function updateClientProduct(Product $product): bool
	{
		$params = $this->check($product->changes(), [
			'serviceid'				=> Expect::int()->required(),
			'pid'					=> Expect::int(),
			'serverid'				=> Expect::int(),
			'regdate'				=> Expect::string(),
			'nextduedate'			=> Expect::string(),
			'terminationdate'		=> Expect::string(),
			'domain'				=> Expect::string(),
			'firstpaymentamount'	=> Expect::float(),
			'recurringamount'		=> Expect::float(),
			'paymentmethod'			=> Expect::string(),
			'billingcycle'			=> Expect::string(),
			'subscriptionid'		=> Expect::string(),
			'status'				=> Expect::string(),
			'notes'					=> Expect::string(),
			'serviceusername'		=> Expect::string(),
			'servicepassword'		=> Expect::string(),
			'overideautosuspend'	=> Expect::string(),
			'overidesuspenduntil'	=> Expect::string(),
			'ns1'					=> Expect::string(),
			'ns2'					=> Expect::string(),
			'dedicatedip'			=> Expect::string(),
			'assignedips'			=> Expect::string(),
			'diskusage'				=> Expect::int(),
			'disklimit'				=> Expect::int(),
			'bwusage'				=> Expect::int(),
			'bwlimit'				=> Expect::int(),
			'suspendreason'			=> Expect::string(),
			'promoid'				=> Expect::int(),
			'unset'					=> Expect::array(),
			'autorecalc'			=> Expect::bool(),
			'customfields'			=> Expect::string(),
			'configoptions'			=> Expect::string(),
		]);

		$response = $this->call('UpdateClientProduct', $params);
		return $response['result'] === 'success';
	}


	/**
	 * Custom API call
	 * @return ItemIterator<Product>
	 */
	public function getProductsInvalid(): ItemIterator
	{
		/** @var ResultList */
		$response = $this->call('ProductGetInvalid');

		/** @var Product[] */
		$items = Arrays::map(
			$response['products']['product'] ?? [],	// @phpstan-ignore nullCoalesce.offset
			fn($x) => new Product($x),
		);

		/** @var ItemIterator<Product> */
		return (new ItemIterator($items))
			->setTotalResults($response['totalresults'])
			->setOffset($response['startnumber'] ?? 0)
			->setLimit($response['numreturned'] ?? 0);
	}
}
