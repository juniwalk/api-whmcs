<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Enums;

use JuniWalk\Utils\Enums\Color;
use JuniWalk\Utils\Enums\LabelledEnum;

enum ClientStatus: string implements LabelledEnum
{
    case Active = 'active';
	case Inactive = 'inactive';
	case Closed = 'closed';


	/**
	 * @return string[]
	 */
	public static function getItems(): iterable
	{
		$items = [];

		foreach (self::cases() as $case) {
			$items[$case->value] = $case->label();
		}

		return $items;
	}


	public function label(): string
	{
		return match($this) {
			self::Active => 'whmcs.enum.client-status.active',
			self::Inactive => 'whmcs.enum.client-status.inactive',
			self::Closed => 'whmcs.enum.client-status.closed',
		};
	}


	public function color(): Color
	{
		return match($this) {
			self::Active => Color::Success,
			self::Inactive => Color::Secondary,
			self::Closed => Color::Danger,
		};
	}


	public function icon(): ?string
	{
		return null;
	}
}
