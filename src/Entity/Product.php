<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2021
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Entity;

class Product extends AbstractEntity
{
	/** @var string */
	const TABLE_NAME = 'tblproducts';

	/** @var int */
	protected $id;

	/** @var string */
	protected $type;

	/** @var int */
	protected $gid;

	/** @var string */
	protected $name;

	/** @var int */
	protected $overagesdisklimit;

	/** @var float */
	protected $overagesdiskprice;


	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}


	/**
	 * @return string
	 */
	public function getType(): string
	{
		return $this->type;
	}


	/**
	 * @param  string  $type
	 * @return void
	 */
	public function setType(string $type): void
	{
		$this->type = $type;
	}


	/**
	 * @return int
	 */
	public function getGroupId(): int
	{
		return $this->gid;
	}


	/**
	 * @param  int  $groupId
	 * @return void
	 */
	public function setGroupId(int $groupId): void
	{
		$this->gid = $groupId;
	}


	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}


	/**
	 * @param  string  $name
	 * @return void
	 */
	public function setName(string $name): void
	{
		$this->name = $name;
	}


	/**
	 * @return int
	 */
	public function getOveragesDiskLimit(): int
	{
		return $this->overagesdisklimit;
	}


	/**
	 * @param  int  $limit
	 * @return void
	 */
	public function setOveragesDiskLimit(int $limit): void
	{
		$this->overagesdisklimit = $limit;
	}


	/**
	 * @return float
	 */
	public function getOveragesDiskPrice(): float
	{
		return $this->overagesdiskprice;
	}


	/**
	 * @param  int  $price
	 * @return void
	 */
	public function setOveragesDiskPrice(int $price): void
	{
		$this->overagesdiskprice = $price;
	}
}
