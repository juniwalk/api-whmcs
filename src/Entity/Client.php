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
}
