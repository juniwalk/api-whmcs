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
	 * @param  int|null  $id
	 * @return self
	 */
	public static function fromClass(string $className, int $id = null): self
	{
		$message = 'No results found for '.$className;

		if (isset($id)) {
			$message .= ' using Id '.$id;
		}

		return new static($message);
	}
}
