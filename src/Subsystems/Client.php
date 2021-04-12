<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2021
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Subsystems;

trait Client
{
	/**
	 * @param  int  $clientId
	 */
	public function getClient(int $clientId)
	{
		return 'client-'.$clientId;
	}
}
