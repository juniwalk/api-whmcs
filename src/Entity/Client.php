<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2024
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Entity;

use JuniWalk\ORM\Interfaces\HtmlOption;
use JuniWalk\Utils\Html;
use JuniWalk\WHMCS\Traits as Tools;

class Client extends AbstractEntity implements HtmlOption
{
	use Tools\Identifier;

	protected ?string $firstname;
	protected ?string $lastname;
	protected ?string $companyname;
	protected ?string $email;
	protected ?string $phonenumber;


	public function getFirstName(): ?string
	{
		return $this->firstname;
	}


	public function getLastName(): ?string
	{
		return $this->lastname;
	}


	public function getFullName(): ?string
	{
		return $this->firstname.' '.$this->lastname;
	}


	public function getCompanyName(): ?string
	{
		return $this->companyname;
	}


	public function getEmail(): ?string
	{
		return $this->email;
	}


	public function getPhoneNumber(): ?string
	{
		return $this->phonenumber;
	}


	public function createOption(): Html
	{
		$params = [
			'%companyName%' => $this->companyname ?? $this->fullname,
			'%fullName%' => $this->fullname,
			'%email%' => $this->email,
			'%id%' => $this->id,
		];

		if ($this->fullname == $this->companyname) {
			$params['%fullName%'] = null;
		}

		$content = Html::el()
			->addHtml(Html::el('div class="border-bottom border-secondary text-truncate"')
				->addHtml(Html::el('span', $params['%companyName%']))
				->addHtml(Html::badge((string) $params['%id%'])->addClass('float-right mt-1'))
			)
			->addHtml(Html::el('small', trim($params['%fullName%'].', '.$params['%email%'], ', ')));

		return Html::option(
			value: $this->id,
			label: strtr('%companyName% (%fullName%) [%id%]', $params),
			content: $content->toHtml(),
		);
	}
}
