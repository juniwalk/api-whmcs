<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2024
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Entity;

class Domain extends AbstractEntity
{
	protected int $id;
	protected ?int $userid;
	protected ?int $orderid;
	protected ?string $regtype;
	protected ?string $domainname;
	protected ?string $registrar;
	protected ?int $regperiod;
	protected ?float $firstpaymentamount;
	protected ?float $recurringamount;
	protected ?string $paymentmethod;
	protected ?string $paymentmethodname;
	protected ?string $regdate;
	protected ?string $expirydate;
	protected ?string $nextduedate;
	protected ?string $status;
	protected ?int $subscriptionid;
	protected ?int $promoid;
	protected ?int $dnsmanagement;
	protected ?int $emailforwarding;
	protected ?int $idprotection;
	protected ?int $donotrenew;
	protected ?string $notes;


	public function getId(): int
	{
		return $this->id;
	}


	public function getName(): ?string
	{
		return $this->domainname;
	}
}
