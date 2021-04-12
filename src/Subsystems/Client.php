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
		$result = $this->createQueryBuilder('clients', 'c')
			->where('c.id = :clientId')
			->setParameter('clientId', $clientId)
			->execute();

		return $result->fetchAllAssociative()[0];
	}
}
