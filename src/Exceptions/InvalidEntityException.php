<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2020
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Exceptions;

use JuniWalk\WHMCS\Entity\AbstractEntity;

class InvalidEntityException extends WHMCSException
{
	/**
	 * @param  string  $className
	 * @return self
	 */
	public static function fromClass(string $className): self
	{
		return new static('Entity '.$className.' has to extend '.AbstractEntity::class);
	}
}
