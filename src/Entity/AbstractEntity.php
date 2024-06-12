<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2024
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Entity;

use BadMethodCallException;
use DateTime;

use JuniWalk\Utils\Enums\Interfaces\LabeledEnum;
use JuniWalk\WHMCS\Enums\InvoiceStatus;

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
	 * @param array<string, ?scalar> $result
	 */
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
		return array_diff_key(get_object_vars($this), self::SnapshotExclude);
	}


	/**
	 * @param  array<string, ?scalar> $values
	 * @return array<string, ?scalar>
	 */
	private function hydrate(array $values): array
	{
		$class = new ReflectionClass($this);

		foreach (static::PropertyTranslate as $to => $from) {
			if (!isset($values[$from]) || isset($values[$to])) {
				continue;
			}

			$values[$to] = $values[$from] ?? null;
		}

		// TODO: Iterate over properties instead of values
		// TODO: Look for the value using lowercase property name

		/** @var array<string, ?scalar> $values */
		foreach ($values as $key => $value) {
			if (!$class->hasProperty($key)) {
				continue;
			}

			$property = $class->getProperty($key);
			$type = $property->getType();

			$value = $this->cast($value, $type);

			if ($type?->allowsNull() ?? true) {
				$value = $value ?: null;
			}

			$property->setValue($this, $value);
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
