<?php

namespace Validators;

use Validator\ValidatorInterface;

class ClientIdValidator implements ValidatorInterface
{
	/**
	 * @var int
	 */
	const CLIENT_ID_IS_VALID = 0;

	/**
	 * @var int
	 */
	const CLIENT_ID_IS_NOT_VALID = 1;

	/**
	 * @param mixed $value
	 *
	 * @return int -   0 if VALUE is correct
	 *                 > 0 otherwise. Returned value specifies type of error.
	 */
	public function valid($value): int
	{
		if (preg_match('/^[a-zA-Z0-9_]{1,}\-[a-zA-Z0-9_]{1,}$/', $value, $out) !== 1) {
			return self::CLIENT_ID_IS_NOT_VALID;
		}

		return self::CLIENT_ID_IS_VALID;
	}

	/**
	 * @param int $validationResult
	 *
	 * @return string
	 */
	public function errorText(int $validationResult): string
	{
		switch ($validationResult) {
			case self::CLIENT_ID_IS_VALID:
				return 'Ok';
			case self::CLIENT_ID_IS_NOT_VALID:
				return 'Given value is not correct Client ID.';
		}
	}

	/**
	 * Returns unique name of the validator.
	 *
	 * @return string
	 */
	public function getName(): string
	{
		return 'ClientIdValidator';
	}
}
