<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2024
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Entity;

use DateTime;

class User extends AbstractEntity
{
	protected int $id;
	protected string $firstname;
	protected string $lastname;
	protected string $email;
	protected DateTime $datecreated;
	protected ?string $validationdata;

	/** @var array<array{id: int, isOnwer: bool}> */
	protected array $clients = [];


	public function getId(): int
	{
		return $this->id;
	}


	public function getFirstName(): ?string
	{
		return $this->firstname;
	}


	public function getLastName(): ?string
	{
		return $this->lastname;
	}


	public function getFullName(): ?string
	{
		return $this->firstname.' '.$this->lastname;
	}


	public function getEmail(): ?string
	{
		return $this->email;
	}
}
