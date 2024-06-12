<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2024
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Entity;

use DateTime;

class Transaction extends AbstractEntity
{
	protected int $id;
	protected int $userid;
	protected int $currency;
	protected string $gateway;
	protected DateTime $date;
	protected string $description;
	protected float $amountin;
	protected float $fees;
	protected float $amountout;
	protected float $rate;
	protected int $transid;
	protected int $invoiceid;
	protected ?int $refundid;


	public function getId(): int
	{
		return $this->id;
	}


	public function getCurrency(): int
	{
		return $this->currency;
	}


	public function getGateway(): string
	{
		return $this->gateway;
	}


	public function getDate(): DateTime
	{
		return clone $this->date;
	}


	public function getDescription(): string
	{
		return $this->description;
	}


	public function getAmountIn(): float
	{
		return $this->amountin;
	}


	public function getFees(): float
	{
		return $this->fees;
	}


	public function getAmountOut(): float
	{
		return $this->amountout;
	}
}
