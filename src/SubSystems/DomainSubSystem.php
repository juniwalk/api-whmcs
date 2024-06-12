<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\SubSystems;

use Nette\Schema\Expect;

trait DomainSubSystem
{
	/**
	 * @param array<string, scalar> $params
	 * @see https://developers.whmcs.com/api-reference/updateclientdomain/
	 */
	public function updateClientDomain(int $domainId, array $params): bool
	{
		$params['domainid'] = $domainId;
		$params = $this->check($params, [
			'domainid'				=> Expect::int()->required(),
			'dnsmanagement'			=> Expect::bool(),
			'emailforwarding'		=> Expect::bool(),
			'idprotection'			=> Expect::bool(),
			'donotrenew'			=> Expect::bool(),
			'type'					=> Expect::string(),	// Transfer, Register
			'regdate'				=> Expect::string(),
			'nextduedate'			=> Expect::string(),
			'expirydate'			=> Expect::string(),
			'domain'				=> Expect::string(),
			'firstpaymentamount'	=> Expect::float(),
			'recurringamount'		=> Expect::float(),
			'registrar'				=> Expect::string(),
			'regperiod'				=> Expect::int(),
			'paymentmethod'			=> Expect::string(),
			'subscriptionid'		=> Expect::string(),
			'status'				=> Expect::string(),	// Active, Cancelled, Terminated
			'notes'					=> Expect::string(),
			'promoid'				=> Expect::int(),
			'autorecalc'			=> Expect::bool(),
			'updatens'				=> Expect::bool(),
			'ns1'					=> Expect::string(),
			'ns2'					=> Expect::string(),
			'ns3'					=> Expect::string(),
			'ns4'					=> Expect::string(),
			'ns5'					=> Expect::string(),
		]);

		$response = $this->call('UpdateClientDomain', $params);
		return $response['result'] === 'success';
	}
}
