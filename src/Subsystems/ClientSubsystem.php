<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Subsystems;

// use JuniWalk\WHMCS\Enums\Sort;
use JuniWalk\WHMCS\Tools\ItemIterator;
use Nette\Schema\Expect;

trait ClientSubsystem
{
	/**
	 * @param  string[]  $params
	 * @return string[]
	 * @see https://developers.whmcs.com/api-reference/getclientsdomains/
	 */
	public function getClientsDomains(
		iterable $params,
		int $offset = 0,
		int $limit = 25
	): ItemIterator
	{
		$params = $this->check($params, [
			'clientid'		=> Expect::int(),
			'domainid'		=> Expect::int(),
			'domain'		=> Expect::string(),
		]);

		$data = $this->call('GetClientsDomains', $params + [
			'limitstart' => $offset,
			'limitnum' => $limit,
		]);

		$items = new ItemIterator($data['domains']);
		$items->setTotalResults($data['totalresults']);
		$items->setOffset($data['startnumber']);
		$items->setLimit($data['numreturned']);
		return $items;
	}
}
