<?php

namespace Validators;

use PHPUnit\Framework\TestCase;

class ClientIdValidatorTest extends TestCase
{
	public function test_getName()
	{
		$clientIdValidator = new ClientIdValidator();
		$name = $clientIdValidator->getName();
		$this->assertEquals('ClientIdValidator', $name);
	}

	/**
	 * @dataProvider dataProvider_test_valid
	 */
	public function test_valid($clientId, $expectedResult, $expectedErrorText)
	{
		$clientIdValidator = new ClientIdValidator();
		$result = $clientIdValidator->valid($clientId);

		$this->assertEquals($expectedResult, $result);
		$this->assertEquals($expectedErrorText, $clientIdValidator->errorText($result));
	}

	public function dataProvider_test_valid()
	{
		return [
			[
				'',
				ClientIdValidator::CLIENT_ID_IS_NOT_VALID,
				'Given value is not correct Client ID.',
			],
			[
				$this->generateString(32),
				ClientIdValidator::CLIENT_ID_IS_NOT_VALID,
				'Given value is not correct Client ID.',
			],
			[
				$this->generateString(32) . '-1.1.1.1',
				ClientIdValidator::CLIENT_ID_IS_NOT_VALID,
				'Given value is not correct Client ID.',
			],
			[
				$this->generateString(32) . '-1.1.1.1-123',
				ClientIdValidator::CLIENT_ID_IS_VALID,
				'Ok',
			],
			[
				$this->generateString(32) . '-abc-1',
				ClientIdValidator::CLIENT_ID_IS_VALID,
				'Ok',
			],
			[
				$this->generateString(32) . '-1.1.1.1-abc',
				ClientIdValidator::CLIENT_ID_IS_NOT_VALID,
				'Given value is not correct Client ID.',
			],
			[
				$this->generateString(32) . '-1.1.1.1-' . $this->generateString(100, '1') ,
				ClientIdValidator::CLIENT_ID_IS_VALID,
				'Ok',
			],
			[
				$this->generateString(32) . '-192.168.1.1-123',
				ClientIdValidator::CLIENT_ID_IS_VALID,
				'Ok',
			],
			[
				$this->generateString(32) . '-1.1.1.1.1-1',
				ClientIdValidator::CLIENT_ID_IS_NOT_VALID,
				'Given value is not correct Client ID.',
			],
			[
				$this->generateString(32) . '-192.168.1.257-123',
				ClientIdValidator::CLIENT_ID_IS_NOT_VALID,
				'Given value is not correct Client ID.',
			],
			[
				$this->generateString(32) . '-hostName-123',
				ClientIdValidator::CLIENT_ID_IS_VALID,
				'Ok',
			],
			[
				$this->generateString(32) . '-incorrectHostNameWithDot.-123',
				ClientIdValidator::CLIENT_ID_IS_NOT_VALID,
				'Given value is not correct Client ID.',
			],
		];
	}

	private function generateString(int $stringLength, string $char = 'a'): string
	{
		$string = '';
		for ($i = 0; $i < $stringLength; $i++) {
			$string .= $char;
		}

		return $string;
	}
}
