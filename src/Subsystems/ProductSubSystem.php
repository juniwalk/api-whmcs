<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2024
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Subsystems;

use Nette\Schema\Expect;

trait ProductSubSystem
{
	/**
	 * @see https://developers.whmcs.com/api-reference/updateclientproduct/
	 */
	public function updateClientProduct(int $serviceId, iterable $params): bool
	{
		$params['serviceid'] = $domainId;
		$params = $this->check($params, [
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
}
