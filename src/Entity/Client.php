<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2024
 * @license   MIT License
 */

namespace JuniWalk\WHMCS\Entity;

use DateTime;
use JuniWalk\ORM\Entity\Interfaces\HtmlOption;
use JuniWalk\ORM\Enums\Display;
use JuniWalk\WHMCS\Enums\ClientStatus as Status;
use JuniWalk\Utils\Html;

class Client extends AbstractEntity implements HtmlOption
{
	protected int $id;
	protected int $groupId;
	protected string $firstName;
	protected string $lastName;
	protected ?string $fullName;
	protected ?string $companyName;
	protected string $email;
	protected ?string $phoneNumber;
	protected ?DateTime $dateCreated;
	protected ?int $currency;
	protected Status $status;


	public function getId(): int
	{
		return $this->id;
	}


	public function getGroupId(): ?int
	{
		return $this->groupId;
	}


	public function getFirstName(): string
	{
		return $this->firstName;
	}


	public function getLastName(): string
	{
		return $this->lastName;
	}


	public function getFullName(): string
	{
		return $this->fullName ?? $this->firstName.' '.$this->lastName;
	}


	public function getCompanyName(): ?string
	{
		return $this->companyName;
	}


	public function getEmail(): string
	{
		return $this->email;
	}


	public function getPhoneNumber(): ?string
	{
		return $this->phoneNumber;
	}


	public function getDateCreated(): ?DateTime
	{
		if (!isset($this->dateCreated)) {
			return null;
		}

		return clone $this->dateCreated;
	}


	public function getCurrency(): ?int
	{
		return $this->currency;
	}


	public function getStatus(): ?Status
	{
		return $this->status;
	}


	public function createOption(?Display $display = null): Html
	{
		$fullName = $this->getFullName();
		$params = [
			'%companyName%' => $this->companyName ?? $fullName,
			'%fullName%' => $fullName,
			'%email%' => $this->email,
			'%id%' => $this->id,
		];

		if ($fullName == $this->companyName) {
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
