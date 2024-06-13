<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2024
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Entity;

use BadMethodCallException;
use DateTime;
use JuniWalk\Utils\Arrays;
use JuniWalk\Utils\Enums\Interfaces\LabeledEnum;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionType;

abstract class AbstractEntity
{
	protected const PropertyTranslate = [];
	protected const SnapshotExclude = [
		'__snapshot' => true,
	];

	/** @var array<string, ?scalar> */
	private array $__snapshot = [];


	/**
	 * @param array<string, ?scalar> $snapshot
	 */
	final public function __construct(array $snapshot)
	{
		$this->__snapshot = $this->hydrate($snapshot);
	}


	/**
	 * @throws BadMethodCallException
	 */
	public function __clone()
	{
		throw new BadMethodCallException;
	}


	/**
	 * @return array<?scalar>
	 */
	public function changes(): array
	{
		$snapshot = $this->snapshot();
		$changes = array_diff_assoc($snapshot, $this->__snapshot);

		foreach (static::PropertyTranslate as $from => $to) {
			$changes[$to] = $snapshot[$from] ?? null;
			unset($changes[$from]);
		}

		// TODO: DateTime types that are null convert to 0000-00-00 00:00:00 ?

		return $changes;
	}


	/**
	 * @return array<string, ?scalar>
	 */
	private function snapshot(): array
	{
		/** @var array<string, ?scalar> */
		$snapshot = array_diff_key(get_object_vars($this), self::SnapshotExclude);
		return Arrays::walk($snapshot, fn($v, $k) => yield mb_strtolower($k) => $v);
	}


	/**
	 * @param  array<string, ?scalar> $snapshot
	 * @return array<string, ?scalar>
	 */
	private function hydrate(array $snapshot): array
	{
		$class = new ReflectionClass($this);

		foreach (static::PropertyTranslate as $to => $from) {
			if (!isset($snapshot[$from]) || isset($snapshot[$to])) {
				continue;
			}

			$snapshot[$to] = $snapshot[$from] ?? null;
		}

		foreach ($class->getProperties() as $property) {
			$name = mb_strtolower($property->getName());
			$value = $this->cast(
				$snapshot[$name] ?? null,
				$type = $property->getType(),
			);

			$isNullable = $type?->allowsNull() ?? true;

			if (!$isNullable && is_null($value)) {
				continue;
			}

			$property->setValue($this, match ($isNullable) {
				true => $value ?: null,
				default => $value,
			});
		}

		return $this->snapshot();
	}


	private function cast(mixed $value, ?ReflectionType $type): mixed
	{
		if (!$type instanceof ReflectionNamedType) {
			return $value;
		}

		$name = $type->getName();

		if (is_array($value) && $name === 'array') {
			return (array) $value;
		}

		if (!is_scalar($value)) {
			return null;
		}

		if (is_a($name, LabeledEnum::class, true)) {
			return $name::make($value, !$type->allowsNull());
		}

		return match ($name) {
			DateTime::class => match (true) {
				$value === '0000-00-00 00:00:00' => null,
				$value === '0000-00-00' => null,
				is_string($value) => new DateTime($value),
				default => null,
			},

			'float' => floatval($value),
			'string' => strval($value),
			'bool' => boolval($value),
			'int' => intval($value),
			default => null,
		};
	}
}
