<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2021
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Entity;

use Doctrine\DBAL\Driver\ResultStatement;

abstract class AbstractEntity
{
	/**
	 * @return string[]
	 * @internal
	 */
	public static function listColumns(self $self = null): iterable
	{
		return get_object_vars($self ?: new static);
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

			$self->$key = $value;
		}

		return $self;
	}
}
