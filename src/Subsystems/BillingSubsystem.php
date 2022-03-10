<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Subsystems;

// use JuniWalk\WHMCS\Enums\InvoiceStatus;
// use JuniWalk\WHMCS\Enums\Sort;
use Nette\Schema\Expect;

trait BillingSubsystem
{
	/**
	 * @param  int  $invoiceId
	 * @return string[]
	 * @see https://developers.whmcs.com/api-reference/getinvoice/
	 */
	public function getInvoice(int $invoiceId): iterable {
		return $this->call('GetInvoice', [
			'invoiceid' => $invoiceId,
		]);
	}


	/**
	 * @param  string|null  $search
	 * @param  string  $sort
	 * @param  int  $offset
	 * @param  int  $limit
	 * @return string[]
	 * @see https://developers.whmcs.com/api-reference/getinvoices/
	 */
	public function getInvoices(
		int $userId = null,
		string $status = null,
		string $orderBy = null,
		string $sort = 'ASC',
		int $offset = 0,
		int $limit = 25
	): iterable {
		return $this->call('GetInvoices', [
			'limitstart' => $offset,
			'limitnum' => $limit,
			'userid' => $userId,
			'status' => $status,			// Draft, Paid, Unpaid, Cancelled, Overdue
			'orderby' => $orderBy,
			'order' => $sort,
		]);
	}


	/**
	 * @param  int $invoiceId
	 * @param  mixed[]  $params
	 * @return bool
	 * @see https://developers.whmcs.com/api-reference/updateinvoice/
	 */
	public function updateInvoice(int $invoiceId, iterable $params): bool
	{
		$params['invoiceid'] = $invoiceId;
		$params = $this->check($params, [
			'invoiceid'				=> Expect::int()->required(),
			'status'				=> Expect::string(),
			'paymentmethod'			=> Expect::string(),
			'taxrate'				=> Expect::float(),
			'taxrate2'				=> Expect::float(),
			'credit'				=> Expect::float(),
			'date'					=> Expect::string(),
			'duedate'				=> Expect::string(),
			'datepaid'				=> Expect::string(),
			'note'					=> Expect::string(),
			'item'					=> Expect::listOf(Expect::structure([
				'description'		=> Expect::string()->required(),
				'amount'			=> Expect::float()->required(),
				'taxed'				=> Expect::bool()->required(),
			])),
			'newitem'				=> Expect::listOf(Expect::structure([
				'description'		=> Expect::string()->required(),
				'amount'			=> Expect::float()->required(),
				'taxed'				=> Expect::bool()->required(),
			])),
			'deletelineids'			=> Expect::arrayOf('int'),
			'publish'				=> Expect::bool(),
			'publishandsendemail'	=> Expect::bool(),
		]);

		dumpe($params);

		$response = $this->call('UpdateInvoice', $params);
		return $response['result'] === 'success';
	}
}
