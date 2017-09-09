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

class UserGetEndpoint extends AbstractEndpoint
{
	protected function validate(array $data): ValidationResult
	{
		$validators = [
			'email' => new ValidatorsCollection([
				new IsNotNullValidator(),
				new IsEmailValidator(),
			])
		];

		$arrayValidator = new ArrayValidator();
		return $arrayValidator->validateArray($validators, $data);
	}

	protected function run(array $data)
	{
		return 'xxx';
	}
}
