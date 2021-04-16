<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2021
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Entity;

class CustomFieldValue extends AbstractEntity
{
	/** @var string */
	const TABLE_NAME = 'tblcustomfieldsvalues';

	/** @var int */
	protected $id;

	/** @var int */
	protected $fieldid;

	/** @var string */
	protected $value;


	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}


	/**
	 * @return int
	 */
	public function getFieldId(): int
	{
		return $this->fieldid;
	}


	/**
	 * @return string
	 */
	public function getValue(): string
	{
		return $this->value;
	}


	/**
	 * @param  string  $value
	 * @return void
	 */
	public function setValue(string $value): void
	{
		$this->value = $value;
	}
}
