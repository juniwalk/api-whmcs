<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Subsystems;

use JuniWalk\WHMCS\Tools\ItemIterator;

trait OrderSubsystem
{
	/**
	 * @see https://developers.whmcs.com/api-reference/acceptorder/
	 */
	public function acceptOrder(int $orderId, array $params): array
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

		return $this->call('AcceptOrder', $params);
	}


	/**
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
		]);

		return $this->call('AddOrder', $params);
	}


	/**
	 * @see https://developers.whmcs.com/api-reference/getproducts/
	 */
	public function getProducts(
		string $productId = '',
		int $groupId = null,
		string $module = null
	): ItemIterator {
		$data = $this->call('GetProducts', [
			'pid' => $productId,
			'gid' => $groupId,
			'module' => $module,
		]);

		$items = new ItemIterator($data['products']['product'] ?? []);
		$items->setTotalResults($data['totalresults']);
		$items->setOffset($data['startnumber'] ?? 0);
		$items->setLimit($data['numreturned'] ?? 0);
		return $items;
	}
}
