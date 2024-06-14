<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2024
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Entity;

use DateTime;
use JuniWalk\WHMCS\Enums\DomainStatus as Status;
use JuniWalk\WHMCS\Enums\DomainType as Type;

class Domain extends AbstractEntity
{
	protected const PropertyTranslate = [
		'domainname' => 'domain',
		'regtype' => 'type',
		'regperiod' => 'registrationperiod',
		// 'regdate' => 'registrationdate',
	];

	protected int $id;
	protected int $userId;
	// protected int $orderId;
	protected Type $regType;
	protected string $domainName;
	// protected string $registrar;
	protected int $regPeriod;
	// protected float $firstPaymentAmount;
	// protected float $recurringAmount;
	// protected string $paymentMethod;
	// protected DateTime $regDate;
	protected ?DateTime $expiryDate;
	protected DateTime $nextDueDate;
	protected Status $status;
	// protected int $subscriptionId;
	// protected int $promoId;
	// protected int $dnsManagement;
	// protected int $emailForwarding;
	// protected int $idProtection;
	// protected int $doNotRenew;
	// protected ?string $notes;


	public function getId(): int
	{
		return $this->id;
	}


	public function getUserId(): int
	{
		return $this->userId;
	}


	public function getType(): Type
	{
		return $this->regType;
	}


	public function getName(): string
	{
		return $this->domainName;
	}


	public function getRegPeriod(): int
	{
		return $this->regPeriod;
	}


	public function getStatus(): Status
	{
		return $this->status;
	}


	public function getExpiryDate(): ?DateTime
	{
		if (!isset($this->expiryDate)) {
			return null;
		}

		return clone $this->expiryDate;
	}
}
