<?php

namespace Endpoints;

use Validator\ArrayValidator;
use Validator\IsIntegerValidator;
use Validator\IsNotNullValidator;
use Validator\IsNumberGreaterThanValidator;
use Validator\IsStringValidator;
use Validator\IsValueFromSetValidator;
use Validator\ValidationResult;
use Validator\ValidatorsCollection;
use Validators\ClientIdValidator;

class UserGetListEndpoint extends AbstractEndpoint
{
	protected function validate(array $data): ValidationResult
	{
		$validators = [
			'clientId' => new ValidatorsCollection([
				new IsNotNullValidator(),
				new IsStringValidator(),
				new ClientIdValidator(),
			]),
			'orderBy' => new ValidatorsCollection([
				new IsNotNullValidator(),
				new IsStringValidator(),
				new IsValueFromSetValidator(['email', 'name', 'isActive'])
			]),
			'limit' => new ValidatorsCollection([
				new IsNotNullValidator(),
				new IsIntegerValidator(),
				new IsNumberGreaterThanValidator(0)
			]),
			'page' => new ValidatorsCollection([
				new IsNotNullValidator(),
				new IsIntegerValidator(),
				new IsNumberGreaterThanValidator(0)
			]),
		];

		$arrayValidator = new ArrayValidator();
		return $arrayValidator->validateArray($validators, $data);
	}

	protected function run(array $data)
	{
		return 'xxx';
	}
}
