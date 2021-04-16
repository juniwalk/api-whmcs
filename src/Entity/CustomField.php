<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2021
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Entity;

class CustomField extends AbstractEntity
{
	/** @var string */
	const TABLE_NAME = 'tblcustomfields';

	/** @var int */
	protected $id;

	/** @var string */
	protected $type;

	/** @var int */
	protected $relid;

	/** @var string */
	protected $fieldname;

	/** @var string */
	protected $fieldtype;


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
	public function getType(): string
	{
		return $this->type;
	}


	/**
	 * @return int
	 */
	public function getRelId(): int
	{
		return $this->relid;
	}


	/**
	 * @return string
	 */
	public function getFieldName(): string
	{
		return $this->fieldname;
	}


	/**
	 * @return string
	 */
	public function getFieldType(): string
	{
		return $this->fieldtype;
	}
}
