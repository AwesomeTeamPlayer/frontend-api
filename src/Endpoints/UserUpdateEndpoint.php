<?php

namespace Endpoints;

use Validator\ArrayValidator;
use Validator\IsBoolValidator;
use Validator\IsEmailValidator;
use Validator\IsNotNullValidator;
use Validator\IsStringValidator;
use Validator\StringLengthValidator;
use Validator\ValidationResult;
use Validator\ValidatorsCollection;
use Validators\ClientIdValidator;

class UserUpdateEndpoint extends AbstractEndpoint
{
	protected function validate(array $data): ValidationResult
	{
		$validators = [
			'clientId' => new ValidatorsCollection([
				new IsNotNullValidator(),
				new IsStringValidator(),
				new ClientIdValidator(),
			]),
			'name' => new ValidatorsCollection([
				new IsNotNullValidator(),
				new IsStringValidator(),
				new StringLengthValidator(3)
			]),
			'email' => new ValidatorsCollection([
				new IsNotNullValidator(),
				new IsEmailValidator(),
			]),
			'isActive' => new ValidatorsCollection([
				new IsNotNullValidator(),
				new IsBoolValidator(),
			])
		];

		$arrayValidator = new ArrayValidator();
		return $arrayValidator->validateArray($validators, $data);
	}

	protected function run(array $data)
	{

	}
}
