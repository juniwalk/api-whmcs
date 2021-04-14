<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2021
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Entity;

class Hosting extends AbstractEntity
{
	/** @var string */
	const TABLE_NAME = 'tblhosting';

	/** @var int */
	protected $id;

	/** @var int */
	protected $userid;

	/** @var int */
	protected $packageid;

	/** @var string */
	protected $domain;

	/** @var string */
	protected $domainstatus;

	/** @var int */
	protected $diskusage;

	/** @var int */
	protected $disklimit;


	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}


	/**
	 * @return int
	 */
	public function getUserId(): int
	{
		return $this->userid;
	}


	/**
	 * @return int
	 */
	public function getPackageId(): int
	{
		return $this->packageid;
	}


	/**
	 * @return string
	 */
	public function getDomain(): string
	{
		return $this->domain;
	}


	/**
	 * @return string
	 */
	public function getDomainStatus(): string
	{
		return $this->domainstatus;
	}


	/**
	 * @return int
	 */
	public function getDiskUsage(): int
	{
		return $this->diskusage;
	}


	/**
	 * @param  int  $diskUsage
	 * @return void
	 */
	public function setDiskUsage(int $diskUsage): void
	{
		$this->diskusage = $diskUsage;
	}


	/**
	 * @return int
	 */
	public function getDiskLimit(): int
	{
		return $this->disklimit;
	}


	/**
	 * @param  int  $diskLimit
	 * @return void
	 */
	public function setDiskLimit(int $diskLimit): void
	{
		$this->disklimit = $diskLimit;
	}
}
