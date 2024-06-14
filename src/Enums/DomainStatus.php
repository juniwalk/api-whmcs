<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Enums;

use JuniWalk\Utils\Enums\Color;
use JuniWalk\Utils\Enums\Interfaces\LabeledEnum;
use JuniWalk\Utils\Enums\Traits\Labeled;

enum DomainStatus: string implements LabeledEnum
{
	use Labeled;

	case Pending = 'pending';
	// case PendingRegistration = 'Pending Registration';
	// case PendingTransfer = 'Pending Transfer';
	case Active = 'active';
	// case Grace = 'Grace';
	// case Redemption = 'Redemption';
	case Expired = 'expired';
	case Cancelled = 'cancelled';
	// case Fraud = 'Fraud';
	// case TransferredAway = 'Transferred Away';


	public function label(): string
	{
		return 'whmcs.enum.domain-status.'.$this->value;
	}


	public function color(): Color
	{
		return match ($this) {
			self::Pending => Color::Warning,
			self::Active => Color::Success,
			self::Expired => Color::Danger,
			self::Cancelled => Color::Secondary,
		};
	}
}
