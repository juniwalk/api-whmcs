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
use Nette\Schema\ValidationException;
use UnitEnum;

class Connector
{
	use Subsystems\ClientSubsystem;
	use Subsystems\BillingSubsystem;
	use Subsystems\DomainSubsystem;
	use Subsystems\LinkSubsystem;
	use Subsystems\OrderSubsystem;
	use Subsystems\ProductSubSystem;
	use Subsystems\SystemSubsystem;
	use Subsystems\UserSubsystem;

	private Client $http;

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

		$result = $response->getBody()->getContents();
		$result = json_decode($result, true);

		if (($result['result'] ?? $result['status']) === 'error') {
			throw ResponseException::fromResult($action, $result);
		}

		return $result;
	}


	/**
	 * @throws ValidationException
	 */
	protected function check(array $params, array $schema): array
	{
		$schema = Expect::structure($schema)
			->skipDefaults()
			->castTo('array');

		try {
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
