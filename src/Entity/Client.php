<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2021
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Entity;

class Client extends AbstractEntity
{
	/** @var string */
	const TABLE_NAME = 'tblclients';

	/** @var int */
	protected $id;

	/** @var string */
	protected $uuid;

	/** @var string */
	protected $firstname;

	/** @var string */
	protected $lastname;

	/** @var string */
	protected $companyname;

	/** @var string */
	protected $email;

	/** @var string */
	protected $phonenumber;


	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}


	/**
	 * @return string
	 */
	public function getGUID(): string
	{
		return $this->uuid;
	}


	/**
	 * @return string
	 */
	public function getFirstName(): string
	{
		return $this->firstname;
	}


	/**
	 * @param  string  $firstName
	 * @return void
	 */
	public function setFirstName(string $firstName): void
	{
		$this->firstname = $firstName;
	}


	/**
	 * @return string
	 */
	public function getLastName(): string
	{
		return $this->lastname;
	}


	/**
	 * @param  string  $lastName
	 * @return void
	 */
	public function setLastName(string $lastName): void
	{
		$this->lastname = $lastName;
	}


	/**
	 * @return string
	 */
	public function getCompanyName(): string
	{
		return $this->companyname;
	}


	/**
	 * @param  string  $companyName
	 * @return void
	 */
	public function setCompanyName(string $companyName): void
	{
		$this->companyname = $companyName;
	}


	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
	}


	/**
	 * @param  string  $email
	 * @return void
	 */
	public function setEmail(string $email): void
	{
		$this->email = $email;
	}


	/**
	 * @return string
	 */
	public function getPhoneNumber(): string
	{
		return $this->phonenumber;
	}


	/**
	 * @param  string  $phoneNumber
	 * @return void
	 */
	public function setPhoneNumber(string $phoneNumber): void
	{
		$this->phonenumber = $phoneNumber;
	}
}
