<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Exceptions;

use Throwable;

final class RequestException extends WHMCSException
{
	public static function fromAction(string $action, ?Throwable $e = null): static
	{
		return new static('Request of '.$action.' in WHMCS api has failed.', 0, $e);
	}
}
