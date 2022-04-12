<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Exceptions;

final class ResponseException extends AbstractException
{
	/**
	 * @param  string  $action
	 * @param  string[]  $result
	 * @return static
	 */
	public static function fromResult(string $action, iterable $result): self
	{
		return new static($action.': '.$result['message']);
	}
}
