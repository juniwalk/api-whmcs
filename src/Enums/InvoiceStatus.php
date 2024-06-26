<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Enums;

use JuniWalk\Utils\Enums\Color;
use JuniWalk\Utils\Enums\Interfaces\LabeledEnum;
use JuniWalk\Utils\Enums\Traits\Labeled;

enum InvoiceStatus: string implements LabeledEnum
{
	use Labeled;

	case Draft = 'draft';
	case Paid = 'paid';
	case Unpaid = 'unpaid';
	case Cancelled = 'cancelled';
	case Overdue = 'overdue';


	public function label(): string
	{
		return 'whmcs.enum.invoice-status.'.$this->value;
	}


	public function color(): Color
	{
		return match ($this) {
			self::Draft => Color::Secondary,
			self::Paid => Color::Success,
			self::Unpaid => Color::Danger,
			self::Cancelled => Color::Secondary,
			self::Overdue => Color::Warning,
		};
	}
}
