<?php

namespace Endpoints;

use Validator\ArrayValidator;
use Validator\IsIntegerValidator;
use Validator\IsNotNullValidator;
use Validator\IsNumberGreaterThanValidator;
use Validator\IsStringValidator;
use Validator\StringLengthValidator;
use Validator\ValidationResult;
use Validator\ValidatorsCollection;
use Validators\ClientIdValidator;

class ProjectAddUserEndpoint extends AbstractEndpoint
{
	protected function validate(array $data): ValidationResult
	{
		$validators = [
			'clientId' => new ValidatorsCollection([
				new IsNotNullValidator(),
				new IsStringValidator(),
				new ClientIdValidator(),
			]),
			'userId' => new ValidatorsCollection([
				new IsNotNullValidator(),
				new IsIntegerValidator(),
				new IsNumberGreaterThanValidator(0)
			]),
			'projectId' => new ValidatorsCollection([
				new IsNotNullValidator(),
				new IsStringValidator(),
				new StringLengthValidator(5),
			]),
		];

		$arrayValidator = new ArrayValidator();
		return $arrayValidator->validateArray($validators, $data);
	}

	protected function run(array $data)
	{

	}
}
