<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\SubSystems;

use JuniWalk\Utils\Arrays;
use JuniWalk\WHMCS\Connector;	// ! Used for @phpstan
use JuniWalk\WHMCS\Entity\Currency;
use JuniWalk\WHMCS\ItemIterator;

/**
 * @phpstan-import-type ResultList from Connector
 */
trait SystemSubSystem
{
	/**
	 * @return ItemIterator<Currency>
	 * @see https://developers.whmcs.com/api-reference/getcurrencies/
	 */
	public function getCurrencies(): ItemIterator
	{
		/** @var ResultList */
		$response = $this->call('GetCurrencies');

		/** @var Currency[] */
		$items = Arrays::map(
			$response['currencies']['currency'] ?? [],	// @phpstan-ignore nullCoalesce.offset
			fn($x) => new Currency($x),
		);

		/** @var ItemIterator<Currency> */
		return (new ItemIterator($items))
			->setTotalResults($response['totalresults'])
			->setOffset($response['startnumber'] ?? 0)
			->setLimit($response['numreturned'] ?? 0);
	}
}
