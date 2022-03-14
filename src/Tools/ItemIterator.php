<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Tools;

class ItemIterator extends \ArrayIterator
{
	/** @var int */
	protected $totalResults;

	/** @var int */
	protected $offset;

	/** @var int */
	protected $limit;


	/**
	 * @param  int  $totalResults
	 * @return void
	 */
	public function setTotalResults(int $totalResults): void
	{
		$this->totalResults = $totalResults;
	}


	/**
	 * @return int
	 */
	public function getTotalResults(): int
	{
		return $this->totalResults;
	}


	/**
	 * @param  int  $offset
	 * @return void
	 */
	public function setOffset(int $offset): void
	{
		$this->offset = $offset;
	}


	/**
	 * @return int
	 */
	public function getOffset(): int
	{
		return $this->offset;
	}


	/**
	 * @param  int  $limit
	 * @return void
	 */
	public function setLimit(int $limit): void
	{
		$this->limit = $limit;
	}


	/**
	 * @return int
	 */
	public function getLimit(): int
	{
		return $this->limit;
	}
}
