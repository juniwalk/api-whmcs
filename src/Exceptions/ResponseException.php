<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Exceptions;

final class ResponseException extends WHMCSException
{
	/**
	 * @param array{result: string, message?: string} $content
	 */
	public static function fromResult(string $action, array $content): static
	{
		return new static($action.': '.($content['message'] ?? $content['result']));
	}
}
