<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2024
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\SubSystems;

use JuniWalk\Utils\Arrays;
use JuniWalk\WHMCS\Connector;	// ! Used for @phpstan
use JuniWalk\WHMCS\Entity\Domain;
use JuniWalk\WHMCS\ItemIterator;

/**
 * @phpstan-import-type ResultList from Connector
 */
trait CustomSubSystem
{
	/**
	 * @return ItemIterator<Domain>
	 */
	public function getDomainsInvalid(): ItemIterator
	{
		/** @var ResultList */
		$response = $this->call('DomainGetInvalid');

		/** @var Domain[] */
		$items = Arrays::map(
			$response['domains']['domain'] ?? [],	// @phpstan-ignore nullCoalesce.offset
			fn($x) => new Domain($x),
		);

		/** @var ItemIterator<Domain> */
		return (new ItemIterator($items))
			->setTotalResults($response['totalresults'])
			->setOffset($response['startnumber'] ?? 0)
			->setLimit($response['numreturned'] ?? 0);
	}
}
