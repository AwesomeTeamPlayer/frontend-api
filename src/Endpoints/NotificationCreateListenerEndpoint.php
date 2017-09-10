<?php

namespace Endpoints;

use NotificationListener;
use Validator\ArrayValidator;
use Validator\IsNotNullValidator;
use Validator\IsStringValidator;
use Validator\StringLengthValidator;
use Validator\ValidationResult;
use Validator\ValidatorsCollection;
use Validators\ClientIdValidator;

class NotificationCreateListenerEndpoint extends AbstractEndpoint
{
	/**
	 * @var NotificationListener
	 */
	private $notificationListener;

	protected function validate(array $data): ValidationResult
	{
		$validators = [
			'clientId' => new ValidatorsCollection([
				new IsNotNullValidator(),
				new IsStringValidator(),
				new ClientIdValidator(),
			]),
			'sourceId' => new ValidatorsCollection([
				new IsNotNullValidator(),
				new IsStringValidator(),
				new StringLengthValidator(3)
			]),
		];

		$arrayValidator = new ArrayValidator();
		return $arrayValidator->validateArray($validators, $data);
	}

	protected function run(array $data)
	{
		$this->notificationListener->addListener(
			$data['clientId'],
			$data['sourceId']
		);
	}
}
