<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2020
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Exceptions;

class NoResultException extends WHMCSException
{
	/**
	 * @param  string  $className
	 * @param  int  $id
	 * @return self
	 */
	public static function fromClass(string $className, int $id): self
	{
		return new static('No results found for '.$className.' using Id '.$id);
	}
}
