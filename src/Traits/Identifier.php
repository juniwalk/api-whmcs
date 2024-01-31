<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2024
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Traits;

trait Identifier
{
	protected int $id;


	final public function getId(): ?int
	{
		return $this->id ?? null;
	}
}
