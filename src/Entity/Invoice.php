<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2024
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Entity;

use DateTime;
use JuniWalk\WHMCS\Enums\InvoiceStatus as Status;

class Invoice extends AbstractEntity
{
	protected const PropertyTranslate = [
		'id' => 'invoiceid',
	];

	protected int $id;
	protected ?string $invoicenum;
	protected int $userid;
	protected DateTime $date;
	protected DateTime $duedate;
	protected ?DateTime $datepaid;
	// protected ?DateTime $lastcaptureattempt;
	protected float $subtotal;
	// protected float $credit;
	protected float $tax;
	// protected float $tax2;
	protected float $total;
	// protected float $balance;
	protected float $taxrate;
	// protected float $taxrate2;
	protected Status $status;
	protected string $paymentmethod;
	protected ?string $notes;
	// protected bool $ccgateway;


	public function getId(): int
	{
		return $this->id;
	}


	public function getNumber(): ?string
	{
		return $this->invoicenum;
	}


	public function getUserId(): int
	{
		return $this->userid;
	}


	public function getDate(): DateTime
	{
		return clone $this->date;
	}


	public function getDateDue(): DateTime
	{
		return clone $this->duedate;
	}


	public function getDatePaid(): ?DateTime
	{
		if (!isset($this->datepaid)) {
			return null;
		}

		return clone $this->datepaid;
	}


	public function getSubTotal(): float
	{
		return $this->subtotal;
	}


	public function getTax(): float
	{
		return $this->tax;
	}


	public function getTotal(): float
	{
		return $this->total;
	}


	public function getTaxRate(): float
	{
		return $this->taxrate;
	}


	public function getStatus(): Status
	{
		return $this->status;
	}


	public function getPaymentMethod(): string
	{
		return $this->paymentmethod;
	}


	public function getNotes(): ?string
	{
		return $this->notes;
	}
}
