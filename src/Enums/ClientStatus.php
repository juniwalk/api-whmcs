<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Enums;

use JuniWalk\Utils\Enums\Color;
use JuniWalk\Utils\Enums\Interfaces\LabeledEnum;
use JuniWalk\Utils\Enums\Traits\Labeled;

enum ClientStatus: string implements LabeledEnum
{
	use Labeled;

    case Active = 'active';
	case Inactive = 'inactive';
	case Closed = 'closed';


	public function label(): string
	{
		return 'whmcs.enum.client-status.'.$this->value;
	}


	public function color(): Color
	{
		return match ($this) {
			self::Active => Color::Success,
			self::Inactive => Color::Secondary,
			self::Closed => Color::Danger,
		};
	}
}
