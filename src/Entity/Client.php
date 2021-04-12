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
	private $id;

	/** @var string */
	private $uuid;

	/** @var string */
	private $firstname;

	/** @var string */
	private $lastname;

	/** @var string */
	private $companyname;

	/** @var string */
	private $email;

	/** @var string */
	private $phonenumber;
}
