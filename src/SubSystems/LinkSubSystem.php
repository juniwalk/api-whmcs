<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\SubSystems;

trait LinkSubSystem
{
	public function createClientLink(int|string $clientId): string
	{
		return $this->url.'/'.$this->adminDir.'/clientssummary.php?userid='.$clientId;
	}


	public function createServiceLink(int|string $serviceId): string
	{
		return $this->url.'/'.$this->adminDir.'/clientsservices.php?productselect='.$serviceId;
	}


	public function createInvoiceLink(int|string $invoiceId): string
	{
		return $this->url.'/'.$this->adminDir.'/invoices.php?action=edit&id='.$invoiceId;
	}
}
