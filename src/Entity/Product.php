<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2024
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Entity;

use JuniWalk\ORM\Traits as Tools;

class Product extends AbstractEntity
{
	use Tools\Identifier;

	protected ?int $clientid;
	protected ?int $pid;
	protected ?string $name;
	protected ?string $groupname;
	protected ?string $domain;
	protected ?string $status;
	protected ?int $diskusage;
	protected ?int $disklimit;


	public function getClientId(): ?int
	{
		return $this->clientid;
	}


	public function getPackageId(): ?int
	{
		return $this->pid;
	}


	public function getName(): ?string
	{
		return $this->name;
	}


	public function getGroupName(): ?string
	{
		return $this->groupname;
	}


	public function getDomain(): ?string
	{
		return $this->domain;
	}


	public function getStatus(): ?string
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
}
