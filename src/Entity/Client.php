<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2024
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Entity;

use JuniWalk\ORM\Interfaces\HtmlOption;
use JuniWalk\ORM\Traits as Tools;
use JuniWalk\Utils\Html;

class Client implements HtmlOption
{
	use Tools\Identifier;

	private ?string $firstname;
	private ?string $lastname;
	private ?string $fullname;
	private ?string $companyname;
	private ?string $email;
	private ?string $phonenumber;

	public static function fromResult(array $result): self
	{
		$self = new static;

		foreach ($result as $key => $value) {
			if (!property_exists($self, $key)) {
				continue;
			}

			$self->$key = $value ?: null;
		}

		$self->fullname ??= $self->firstname.' '.$self->lastname;
		$self->companyname ??= $self->fullname;

		return $self;
	}


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
		return $this->fullname;
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
			'%companyName%' => $this->companyname,
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
