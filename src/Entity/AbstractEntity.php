<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2024
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Entity;

abstract class AbstractEntity
{
	protected const SnapshotExclude = [
		'__snapshot' => true,
	];

	private array $__snapshot = [];

	final public function __construct(array $result)
	{
		$this->__snapshot = $this->hydrate($result);
	}


	public static function fromResult(array $result): self
	{
		return new static($result);
	}


	public function changes(): array
	{
		return array_diff_assoc($this->__snapshot, $this->snapshot());
	}


	private function snapshot(): array
	{
		return array_diff_key(get_object_vars($this), self::SnapshotExclude);
	}


	private function hydrate(array $values): array
	{
		foreach ($values as $key => $value) {
			if (!property_exists($this, $key)) {
				continue;
			}

			$this->$key = $value ?: null;
		}

		return $this->snapshot();;
	}
}
