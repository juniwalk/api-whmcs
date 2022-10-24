<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Enums;

use JuniWalk\Utils\Enums\Color;
use JuniWalk\Utils\Enums\LabeledEnum;
use JuniWalk\Utils\Enums\Traits\Labeled;

enum ClientStatus: string implements LabeledEnum
{
	use Labeled;

    case Active = 'active';
	case Inactive = 'inactive';
	case Closed = 'closed';


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
}
