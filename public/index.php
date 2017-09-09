<?php

use Endpoints\AbstractEndpoint;
use Endpoints\InvalidDataException;
use Endpoints\UserCreateEndpoint;
use Endpoints\UserGetEndpoint;
use Endpoints\UserGetListEndpoint;
use Endpoints\UserUpdateEndpoint;

require __DIR__ . '/../vendor/autoload.php';

class EndpointsHandler
{
	public $error = null;

	public function userCreate($name, $email, $isActive)
	{
		return $this->execute(new UserCreateEndpoint(), [
			'name' => $name,
			'email' => $email,
			'isActive' => $isActive,
		]);
	}

	public function userUpdate($name, $email, $isActive)
	{
		return $this->execute(new UserUpdateEndpoint(), [
			'name' => $name,
			'email' => $email,
			'isActive' => $isActive,
		]);
	}

	public function userGet($email)
	{
		return $this->execute(new UserGetEndpoint(), [
			'email' => $email,
		]);
	}

	public function userGetList($orderBy, $limit, $page)
	{
		return $this->execute(new UserGetListEndpoint(), [
			'orderBy' => $orderBy,
			'limit' => $limit,
			'page' => $page,
		]);
	}

	private function execute(AbstractEndpoint $endpointsObject, array $data)
	{
		try {
			return $endpointsObject->execute($data);
		} catch (InvalidDataException $exception) {
			$this->error = [
				'code' => -32000,
				'message' => 'Invalid data',
				'data' => $exception->getErrorTexts()
			];
		}
	}

}

$methods = new EndpointsHandler();
$server = new JsonRpc\Server($methods);
$server->setObjectsAsArrays();
$server->receive();
