<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Enums;

use JuniWalk\Utils\Enums\Color;
use JuniWalk\Utils\Enums\Interfaces\LabeledEnum;
use JuniWalk\Utils\Enums\Traits\Labeled;

enum DomainType: string implements LabeledEnum
{
	use Labeled;

	case Register = 'register';
	case Transfer = 'transfer';


	public function label(): string
	{
		return 'whmcs.enum.domain-type.'.$this->value;
	}


	public function color(): Color
	{
		return Color::Secondary;
	}
}
