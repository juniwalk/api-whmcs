<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2021
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Entity;

use Doctrine\DBAL\Driver\ResultStatement;
use Nette\Utils\Strings;
use ReflectionProperty;

abstract class AbstractEntity
{
	/** @var string[] */
	private $__snapshot = [];


	/**
	 * @param  static|null  $self
	 * @return string[]
	 * @internal
	 */
	public static function listColumns(self $self = null): iterable
	{
		$columns = get_object_vars($self ?: new static);
		unset($columns['__snapshot']);
		return $columns;
	}


	/**
	 * @param  static|null  $self
	 * @return string[]
	 * @internal
	 */
	public static function listChanges(self $self): iterable
	{
		return array_diff_assoc(
			static::listColumns($self),
			$self->__snapshot
		);
	}


	/**
	 * @param  ResultStatement  $result
	 * @return static
	 * @internal
	 */
	public static function fromResult(ResultStatement $result): self
	{
		$items = $result->fetchAssociative();
		$self = new static;

		foreach ($items as $key => $value) {
			if (!property_exists($self, $key)) {
				continue;
			}

			$self->$key = static::castToType($key, $value);
		}

		$self->__snapshot = static::listColumns($self);

		return $self;
	}


	/**
	 * @param  string  $key
	 * @param  string  $value
	 * @return mixed
	 */
	private static function castToType(string $key, string $value)
	{
		$rp = new ReflectionProperty(static::class, $key);
		$matches = Strings::match(
			$rp->getDocComment(),
			'/@var\s+([^\s]+)/i'
		);

		switch (Strings::lower($matches[1])) {
			case 'int':
				return (int) $value;
				break;

			case 'float':
				return (float) $value;
				break;

			default: break;
		}

		return $value;
	}
}
