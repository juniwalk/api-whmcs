<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Enums;

use JuniWalk\Utils\Enums\Color;
use JuniWalk\Utils\Enums\LabeledEnum;
use JuniWalk\Utils\Enums\LabeledTrait;

enum InvoiceStatus: string implements LabeledEnum
{
	use LabeledTrait;

	case Draft = 'draft';
	case Paid = 'paid';
	case Unpaid = 'unpaid';
	case Cancelled = 'cancelled';
	case Overdue = 'overdue';


	public function label(): string
	{
		return match($this) {
			self::Draft => 'whmcs.enum.invoice-status.draft',
			self::Paid => 'whmcs.enum.invoice-status.paid',
			self::Unpaid => 'whmcs.enum.invoice-status.unpaid',
			self::Cancelled => 'whmcs.enum.invoice-status.cancelled',
			self::Overdue => 'whmcs.enum.invoice-status.overdue',
		};
	}


	public function color(): Color
	{
		return match($this) {
			self::Draft => Color::Secondary,
			self::Paid => Color::Success,
			self::Unpaid => Color::Danger,
			self::Cancelled => Color::Secondary,
			self::Overdue => Color::Warning,
		};
	}
}
