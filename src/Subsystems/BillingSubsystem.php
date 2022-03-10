<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Subsystems;

// use JuniWalk\WHMCS\Enums\InvoiceStatus;
// use JuniWalk\WHMCS\Enums\Sort;

trait BillingSubsystem
{
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
			'userid' => null,
			'status' => null,			// Draft, Paid, Unpaid, Cancelled, Overdue
			'orderby' => null,
			'order' => $sort,
		]);
	}
}
