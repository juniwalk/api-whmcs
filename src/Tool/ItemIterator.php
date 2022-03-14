<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Tools;

class ItemIterator extends ArrayIterator
{
	/** @var int */
	private $totalResults;

	/** @var int */
	private $startNumber;

	/** @var int */
	private $numberReturned;


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
	 * @param  int  $startNumber
	 * @return void
	 */
	public function setStartNumber(int $startNumber): void
	{
		$this->startNumber = $startNumber;
	}


	/**
	 * @return int
	 */
	public function getStartNumber(): int
	{
		return $this->startNumber;
	}


	/**
	 * @param  int  $numberReturned
	 * @return void
	 */
	public function setNumberReturned(int $numberReturned): void
	{
		$this->numberReturned = $numberReturned;
	}


	/**
	 * @return int
	 */
	public function getNumberReturned(): int
	{
		return $this->numberReturned;
	}
}
