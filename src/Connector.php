<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JuniWalk\WHMCS\Exceptions\RequestException;
use JuniWalk\WHMCS\Exceptions\ResponseException;
use Nette\Schema\Expect;
use Nette\Schema\Processor;
use Nette\Schema\Schema;
use Nette\Schema\ValidationException;
use UnitEnum;

/**
 * @phpstan-type ResultList array{
 * 		result: string,
 * 		totalresults: int,
 * 		startnumber?: int,
 * 		numreturned?: int,
 * }
 */
class Connector
{
	use SubSystems\ClientSubSystem;
	use SubSystems\BillingSubSystem;
	use SubSystems\DomainSubSystem;
	use SubSystems\LinkSubSystem;
	use SubSystems\OrderSubSystem;
	use SubSystems\ProductSubSystem;
	use SubSystems\SystemSubSystem;
	use SubSystems\UserSubSystem;

	private Client $http;

	/**
	 * @param array<string, mixed> $params
	 */
	public function __construct(
		private string $url,
		private string $identifier,
		private string $secret,
		private string $adminDir,
		private ?string $accessKey = null,
		array $params = [],
	) {
		$this->http = new Client($params + [
			'base_uri' => $url,
			'timeout' => 6
		]);
	}


	/**
	 * @param  array<string, mixed> $params
	 * @return array<string, mixed>
	 * @throws RequestException
	 * @throws ResponseException
	 */
	public function call(string $action, array $params = []): array
	{
		$params = array_merge($params, [
			'identifier' => $this->identifier,
			'secret' => $this->secret,
			'accesskey' => $this->accessKey,
			'action' => $action,
			'responsetype' => 'json',
		]);

		try {
			$response = $this->http->request('POST', '/includes/api.php', [
				'form_params' => $params,
			]);

		} catch (GuzzleException $e) {
			throw RequestException::fromAction($action, $e);
		}

		$content = $response->getBody()->getContents();
		/** @var array{result: string, message?: string} */
		$content = json_decode($content, true);

		if ($content['result'] === 'error') {
			throw ResponseException::fromResult($action, $content);
		}

		return $content;
	}


	/**
	 * @param  array<string, mixed> $params
	 * @param  array<string, Schema> $schema
	 * @return array<string, mixed>
	 * @throws ValidationException
	 */
	protected function check(array $params, array $schema): array
	{
		$schema = Expect::structure($schema)
			->skipDefaults()
			->castTo('array');

		try {
			/** @var array<string, mixed> */
			$params = (new Processor)->process($schema, $params);

		} catch (ValidationException $e) {
			throw $e;
		}

		foreach ($params as $key => $value) {
			if (!$value instanceof UnitEnum) {
				continue;
			}

			$params[$key] = $value->name;
		}

		return $params;
	}
}
