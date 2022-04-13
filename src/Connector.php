<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS;

use GuzzleHttp\Client;
use JuniWalk\WHMCS\Exceptions\ResponseException;
use Nette\Schema\Expect;
use Nette\Schema\Processor;
use Nette\Schema\ValidationException;

class Connector
{
	use Subsystems\BillingSubsystem;
	use Subsystems\DomainSubsystem;
	use Subsystems\OrderSubsystem;
	use Subsystems\SystemSubsystem;
	use Subsystems\UserSubsystem;

	/** @var string */
	private $identifier;

	/** @var string */
	private $secret;

	/** @var string */
	private $accessKey;

	/** @var Client */
	private $http;


	/**
	 * @param  string  $url
	 * @param  string  $identifier
	 * @param  string  $secret
	 * @param  string  $accessKey
	 * @param  string[]  $params
	 */
	public function __construct(
		string $url,
		string $identifier,
		string $secret,
		string $accessKey = null,
		iterable $params = []
	) {
		$this->identifier = $identifier;
		$this->secret = $secret;
		$this->accessKey = $accessKey;
		$this->http = new Client($params + [
			'base_uri' => $url,
			'timeout' => 6
		]);
	}


	/**
	 * @param  string  $action
	 * @param  string  $params
	 * @return string[]
	 * @throws ClientException
	 * @throws ResponseException
	 */
	protected function call(string $action, iterable $params): iterable
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

		} catch (ClientException $e) {
			throw $e;
		}

		$result = $response->getBody()->getContents();
		$result = json_decode($result, true);

		if (($result['result'] ?? $result['status']) === 'error') {
			throw ResponseException::fromResult($action, $result);
		}

		return $result;
	}


	/**
	 * @param  string[]  $params
	 * @param  Expect[]  $schema
	 * @return string[]
	 * @throws ValidationException
	 */
	protected function check(iterable $params, iterable $schema): iterable
	{
		$schema = Expect::structure($schema)
			->skipDefaults()
			->castTo('array');

		try {
			$params = (new Processor)->process($schema, $params);

		} catch (ValidationException $e) {
			throw $e;
		}

		return $params;
	}
}
