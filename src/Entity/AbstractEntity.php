<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2024
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Entity;

use BadMethodCallException;

abstract class AbstractEntity
{
	protected const PropertyTranslate = [];
	protected const SnapshotExclude = [
		'__snapshot' => true,
	];

	private array $__snapshot = [];


	final public function __construct(array $result)
	{
		$this->__snapshot = $this->hydrate($result);
	}


	/**
	 * @throws BadMethodCallException
	 */
	public function __clone()
	{
		throw new BadMethodCallException;
	}


	public static function fromResult(array $result): self
	{
		return new static($result);
	}


	public function changes(): array
	{
		$changes = array_diff_assoc($this->snapshot(), $this->__snapshot);

		foreach (static::PropertyTranslate as $from => $to) {
			$changes[$to] = $changes[$from] ?? null;
			unset($changes[$from]);
		}

		return $changes;
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

		return $this->snapshot();
	}
}
