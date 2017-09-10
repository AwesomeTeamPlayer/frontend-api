<?php

namespace Endpoints;

use Validator\ArrayValidator;
use Validator\IsIntegerValidator;
use Validator\IsNotNullValidator;
use Validator\IsNumberGreaterThanValidator;
use Validator\ValidationResult;
use Validator\ValidatorsCollection;

class ProjectGetProjectsForUserEndpoint extends AbstractEndpoint
{
	protected function validate(array $data): ValidationResult
	{
		$validators = [
			'userId' => new ValidatorsCollection([
				new IsNotNullValidator(),
				new IsIntegerValidator(),
				new IsNumberGreaterThanValidator(0),
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

	}
}
