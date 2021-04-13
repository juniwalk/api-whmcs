<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2021
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Subsystems;

use JuniWalk\WHMCS\Entity\Client;

trait ClientSubsystem
{
	/**
	 * @param  int  $clientId
	 * @return Client
	 */
	public function getClient(int $clientId): Client
	{
		return $this->getOneById($clientId, Client::class);
	}


	/**
	 * @param  int  $clientId
	 * @return Client|null
	 */
	public function findClient(int $clientId): ?Client
	{
		return $this->findOneById($clientId, Client::class);
	}
}
