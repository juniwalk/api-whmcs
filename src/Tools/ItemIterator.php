<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Tools;

class ItemIterator extends \ArrayIterator
{
	protected ?int $totalResults;
	protected ?int $offset;
	protected ?int $limit;


	public function setTotalResults(?int $totalResults): void
	{
		$this->totalResults = $totalResults;
	}


	public function getTotalResults(): ?int
	{
		return $this->totalResults;
	}


	public function setOffset(?int $offset): void
	{
		$this->offset = $offset;
	}


	public function getOffset(): ?int
	{
		return $this->offset;
	}


	public function setLimit(?int $limit): void
	{
		$this->limit = $limit;
	}


	public function getLimit(): ?int
	{
		return $this->limit;
	}
}
