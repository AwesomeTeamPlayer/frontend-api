<?php

namespace Endpoints;

use NotificationListenerRepository;
use Validator\ArrayValidator;
use Validator\IsNotNullValidator;
use Validator\IsStringValidator;
use Validator\ValidationResult;
use Validator\ValidatorsCollection;
use Validators\ClientIdValidator;

class NotificationRemoveAllListenersByClientIdEndpoint extends AbstractEndpoint
{
	/**
	 * @var NotificationListenerRepository
	 */
	private $notificationListener;

	public function __construct(NotificationListenerRepository $notificationListener)
	{
		$this->notificationListener = $notificationListener;
	}

	protected function validate(array $data): ValidationResult
	{
		$validators = [
			'clientId' => new ValidatorsCollection([
				new IsNotNullValidator(),
				new IsStringValidator(),
				new ClientIdValidator(),
			])
		];

		$arrayValidator = new ArrayValidator();
		return $arrayValidator->validateArray($validators, $data);
	}

	protected function run(array $data)
	{
		$this->notificationListener->removeListenerByClientId(
			$data['clientId']
		);

		return $data;
	}
}
