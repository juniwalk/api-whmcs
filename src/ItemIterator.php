<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS;

use ArrayIterator;

/**
 * @template T
 * @extends ArrayIterator<int, T>
 */
class ItemIterator extends ArrayIterator
{
	protected ?int $totalResults;
	protected ?int $offset;
	protected ?int $limit;


	/**
	 * @return self<T>
	 */
	public function setTotalResults(?int $totalResults): self
	{
		$this->totalResults = $totalResults;
		return $this;
	}


	public function getTotalResults(): ?int
	{
		return $this->totalResults;
	}


	/**
	 * @return self<T>
	 */
	public function setOffset(?int $offset): self
	{
		$this->offset = $offset;
		return $this;
	}


	public function getOffset(): ?int
	{
		return $this->offset;
	}


	/**
	 * @return self<T>
	 */
	public function setLimit(?int $limit): self
	{
		$this->limit = $limit;
		return $this;
	}


	public function getLimit(): ?int
	{
		return $this->limit;
	}
}
