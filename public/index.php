<?php

use Endpoints\AbstractEndpoint;
use Endpoints\InvalidDataException;
use Endpoints\ProjectAddUserEndpoint;
use Endpoints\ProjectGetProjectsForUserEndpoint;
use Endpoints\ProjectGetUserForProjectEndpoint;
use Endpoints\ProjectHasUserAccessEndpoint;
use Endpoints\ProjectRemoveUserEndpoint;
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

	public function projectAddUser($userId, $projectId)
	{
		return $this->execute(new ProjectAddUserEndpoint(), [
			'userId' => $userId,
			'projectId' => $projectId,
		]);
	}

	public function projectRemoveUser($userId, $projectId)
	{
		return $this->execute(new ProjectRemoveUserEndpoint(), [
			'userId' => $userId,
			'projectId' => $projectId,
		]);
	}

	public function projectHasUserAccess($userId, $projectId)
	{
		return $this->execute(new ProjectHasUserAccessEndpoint(), [
			'userId' => $userId,
			'projectId' => $projectId,
		]);
	}

	public function projectGetUsersForProject($projectId, $limit, $page)
	{
		return $this->execute(new ProjectGetUserForProjectEndpoint(), [
			'projectId' => $projectId,
			'limit' => $limit,
			'page' => $page,
		]);
	}

	public function projectGetProjectsForUser($userId, $limit, $page)
	{
		return $this->execute(new ProjectGetProjectsForUserEndpoint(), [
			'userId' => $userId,
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
