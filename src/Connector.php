<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS;

use GuzzleHttp\Client;

class Connector
{
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
	 * @param  string[]  $params
	 */
	public function __construct(
		string $url,
		string $identifier,
		string $secret,
		iterable $params = []
	) {
		$this->identifier = $identifier;
		$this->secret = $secret;
		$this->http = new Client($params + [
			'base_uri' => $url,
			'timeout' => 2
		]);
	}


	/**
	 * @param  string  $action
	 * @param  string  $params
	 * @return string[]
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
			// What shall we do?
			throw $e;
		}

		if ($response->getStatusCode() !== 200) {
			// What shall we do?
		}

		return json_decode($response->getBody()->getContents(), true);
	}
}
