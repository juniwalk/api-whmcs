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
	private $username;

	/** @var string */
	private $password;

	/** @var Client */
	private $http;


	/**
	 * @param  string  $url
	 * @param  string  $username
	 * @param  string  $password
	 * @param  string[]  $params
	 */
	public function __construct(string $url, string $username, string $password, iterable $params = [])
	{
		$this->username = $username;
		$this->password = $password;
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
			'username' => $this->username,
			'password' => $this->password,
			'action' => $action,
			'responsetype' => 'json',
		]);

		dump($params);

		try {
			$response = $this->http->request('POST', '/includes/api.php', $params);

		} catch (ClientException $e) {
			// What shall we do?
			throw $e;
		}

		if ($response->getStatusCode() !== 200) {
			// What shall we do?
		}

		return json_decode($response->getBody(), true);
	}
}
