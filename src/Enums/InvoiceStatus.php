<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Enums;

enum InvoiceStatus
{
	/** @var string */
	case Draft;
	case Paid;
	case Unpaid;
	case Cancelled;
	case Overdue;
}
