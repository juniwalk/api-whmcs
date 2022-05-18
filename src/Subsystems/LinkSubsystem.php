<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Subsystems;

trait LinkSubsystem
{
	/**
	 * @param  int  $invoiceId
	 * @return string
	 */
	public function createInvoiceLink(int $invoiceId): string
	{
		return $this->url.'/'.$this->adminDir.'/invoices.php?action=edit&id='.$invoiceId;
	}
}
