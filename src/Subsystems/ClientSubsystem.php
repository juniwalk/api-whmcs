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
		$query = $this->createQueryBuilder(Client::class, 'c')
			->where('c.id = :clientId')
			->setParameter('clientId', $clientId);

		$result = $query->execute();

		return Client::fromResult($result);
	}
}
