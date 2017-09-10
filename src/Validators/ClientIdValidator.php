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
		if (preg_match('/^[a-z0-9]{32}\-([a-zA-Z0-9\.]{1,})\-[0-9]{1,}$/', $value, $out) !== 1) {
			return self::CLIENT_ID_IS_NOT_VALID;
		}

		if (strpos($out[1], '.') !== false) {
			if ($this->validIpAddress($out[1]) === true) {
				return self::CLIENT_ID_IS_VALID;
			}
			return self::CLIENT_ID_IS_NOT_VALID;
		}

		if ($this->validHostName($out[1]) === true) {
			return self::CLIENT_ID_IS_VALID;
		}

		return self::CLIENT_ID_IS_NOT_VALID;
	}

	/**
	 * @param string $ipAddress
	 *
	 * @return bool
	 */
	private function validIpAddress(string $ipAddress): bool
	{
		$parts = explode('.', $ipAddress);
		if (count($parts) !== 4) {
			return false;
		}

		foreach ($parts as $part) {
			if ((int) $part > 256) {
				return false;
			}
		}

		return true;
	}

	/**
	 * @param string $hostName
	 * 
	 * @return bool
	 */
	private function validHostName(string $hostName): bool
	{
		if (preg_match('/^[a-zA-Z0-9]{1,}$/', $hostName, $out) !== 1) {
			return false;
		}

		return true;
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
