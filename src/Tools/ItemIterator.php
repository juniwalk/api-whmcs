<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Tools;

class ItemIterator extends \ArrayIterator
{
	/** @var int|null */
	protected $totalResults;

	/** @var int|null */
	protected $offset;

	/** @var int|null */
	protected $limit;


	/**
	 * @param  int|null  $totalResults
	 * @return void
	 */
	public function setTotalResults(?int $totalResults): void
	{
		$this->totalResults = $totalResults;
	}


	/**
	 * @return int|null
	 */
	public function getTotalResults(): ?int
	{
		return $this->totalResults;
	}


	/**
	 * @param  int|null  $offset
	 * @return void
	 */
	public function setOffset(?int $offset): void
	{
		$this->offset = $offset;
	}


	/**
	 * @return int|null
	 */
	public function getOffset(): ?int
	{
		return $this->offset;
	}


	/**
	 * @param  int|null  $limit
	 * @return void
	 */
	public function setLimit(?int $limit): void
	{
		$this->limit = $limit;
	}


	/**
	 * @return int|null
	 */
	public function getLimit(): ?int
	{
		return $this->limit;
	}
}
