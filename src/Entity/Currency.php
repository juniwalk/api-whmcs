<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2024
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Entity;

class Currency extends AbstractEntity
{
	protected int $id;
	protected ?string $code;
	protected ?string $prefix;
	protected ?string $suffix;
	protected ?int $format;
	protected ?float $rate;


	public function getId(): int
	{
		return $this->id;
	}


	public function getCode(): ?string
	{
		return $this->code;
	}


	public function getPrefix(): ?string
	{
		return $this->prefix;
	}


	public function getSuffix(): ?string
	{
		return $this->suffix;
	}


	public function getFormat(): ?int
	{
		return $this->format;
	}


	public function getRate(): ?float
	{
		return (float) $this->rate;
	}
}
