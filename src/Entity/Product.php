<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2021
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Entity;

class Product extends AbstractEntity
{
	/** @var string */
	const TABLE_NAME = 'tblproducts';

	/** @var int */
	protected $id;

	/** @var string */
	protected $type;

	/** @var int */
	protected $gid;

	/** @var string */
	protected $name;

	/** @var int */
	protected $overagesdisklimit;

	/** @var float */
	protected $overagesdiskprice;
}
