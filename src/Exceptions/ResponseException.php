<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Exceptions;

final class ResponseException extends WHMCSException
{
	public static function fromResult(string $action, iterable $result): static
	{
		return new static($action.': '.$result['message']);
	}
}
