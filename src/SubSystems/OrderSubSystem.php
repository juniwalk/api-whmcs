<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
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
trait OrderSubSystem
{
	/**
	 * @param array<string, scalar> $params
	 * @see https://developers.whmcs.com/api-reference/acceptorder/
	 */
	public function acceptOrder(int $orderId, array $params): bool
	{
		$params['orderid'] = $orderId;
		$params = $this->check($params, [
			'orderid'				=> Expect::int()->required(),
			'serverid'				=> Expect::int(),
			'serviceusername'		=> Expect::string(),
			'servicepassword'		=> Expect::string(),
			'registrar'				=> Expect::string(),
			'sendregistrar'			=> Expect::bool(),
			'autosetup'				=> Expect::bool(),
			'sendemail'				=> Expect::bool(),
		]);

		$response = $this->call('AcceptOrder', $params);
		return $response['result'] === 'success';
	}


	/**
	 * @param  array<string, scalar> $params
	 * @return array<string, int|string>
	 * @see https://developers.whmcs.com/api-reference/addorder/
	 */
	public function addOrder(int $clientId, string $paymentMethod, array $params): array
	{
		$params['clientid'] = $clientId;
		$params['paymentmethod'] = $paymentMethod;
		$params = $this->check($params, [
			'clientid'				=> Expect::int()->required(),
			'paymentmethod'			=> Expect::string()->required(),
			'pid'					=> Expect::arrayOf('int'),
			'domain'				=> Expect::arrayOf('string'),
			'billingcycle'			=> Expect::arrayOf('string'),
			'customfields'			=> Expect::arrayOf('string'),
			'priceoverride'			=> Expect::arrayOf('float'),
			'noemail'				=> Expect::bool(),
		]);

		/** @var array<string, int|string> */
		return $this->call('AddOrder', $params);
	}


	/**
	 * @return ItemIterator<Product>
	 * @see https://developers.whmcs.com/api-reference/getproducts/
	 */
	public function getProducts(
		int|string|null $productId = null,
		?int $groupId = null,
		?string $module = null,
	): ItemIterator {
		/** @var ResultList */
		$response = $this->call('GetProducts', [
			'pid' => (string) $productId,
			'gid' => $groupId,
			'module' => $module,
		]);

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
