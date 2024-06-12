<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\DI;

use JuniWalk\WHMCS\Connector;
use Nette\DI\CompilerExtension;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

final class WhmcsExtension extends CompilerExtension
{
	public function getConfigSchema(): Schema
	{
		return Expect::structure([
			'url' => Expect::string()->required(),
			'identifier' => Expect::string()->required(),
			'secret' => Expect::string()->required(),
			'adminDir' => Expect::string()->required(),
			'accessKey' => Expect::string(),
			'params' => Expect::structure([])
				->otherItems(Expect::string())
				->castTo('array'),
		])->castTo('array');
	}


	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$config = $this->getConfig();

		$builder->addDefinition($this->prefix('connector'))
			->setFactory(Connector::class, (array) $config);
	}
}
