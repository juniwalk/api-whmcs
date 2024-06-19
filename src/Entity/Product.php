<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2024
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Entity;

use JuniWalk\WHMCS\Enums\DomainStatus as Status;

/**
 * @phpstan-type Price array{
 * 		monthly: float,
 * 		quarterly: float,
 * 		semiannually: float,
 * 		annually: float,
 * 		biennially: float,
 * 		triennially: float,
 * }
 * @phpstan-type PriceList array<string, ?Price>
 */
class Product extends AbstractEntity
{
	protected const PropertyTranslate = [
		'id' => 'serviceid',
	];

	protected int $id;
	protected ?int $clientid;
	protected int $pid;
	protected ?int $gid;
	protected ?string $type;
	protected string $name;
	protected ?string $slug;
	protected ?string $description;
	protected ?string $groupname;
	protected ?string $domain;
	protected ?string $paytype;
	protected ?Status $status;
	protected ?int $diskusage;
	protected ?int $disklimit;

	/** @var PriceList */
	protected array $pricing;


	public function getId(): int
	{
		return $this->id;
	}


	public function getClientId(): ?int
	{
		return $this->clientid;
	}


	public function getPackageId(): int
	{
		return $this->pid;
	}


	public function getType(): ?string
	{
		return $this->type;
	}


	public function getName(): string
	{
		return $this->name;
	}


	public function getDescription(): ?string
	{
		return $this->description;
	}


	public function getGroupId(): ?int
	{
		return $this->gid;
	}


	public function getGroupName(): ?string
	{
		return $this->groupname;
	}


	public function getDomain(): ?string
	{
		return $this->domain;
	}


	public function getPayType(): ?string
	{
		return $this->paytype;
	}


	public function getStatus(): ?Status
	{
		return $this->status;
	}


	public function getDiskUsage(): ?int
	{
		return $this->diskusage;
	}


	public function setDiskUsage(?int $diskUsage): void
	{
		$this->diskusage = $diskUsage;
	}


	public function setDiskLimit(?int $disklimit): void
	{
		$this->disklimit = $disklimit ?? 0;
	}


	public function getDiskLimit(): ?int
	{
		return $this->disklimit;
	}


	public function isDiskOverLimit(): bool
	{
		if (!$this->disklimit) {
			return false;
		}

		return $this->diskusage >= $this->disklimit;
	}


	/**
	 * @return PriceList
	 */
	public function getPricing(): array
	{
		return $this->pricing;
	}
}
