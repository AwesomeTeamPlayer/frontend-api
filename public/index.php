<?php

use Endpoints\AbstractEndpoint;
use Endpoints\InvalidDataException;
use Endpoints\NotificationCreateListenerEndpoint;
use Endpoints\NotificationRemoveAllListenersByClientIdEndpoint;
use Endpoints\NotificationRemoveListenerEndpoint;
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

	/**
	 * @var NotificationListenerRepository
	 */
	private $notificationListener;

	public function __construct(NotificationListenerRepository $notificationListener)
	{
		$this->notificationListener = $notificationListener;
	}

	public function userCreate($clientId, $name, $email, $isActive)
	{
		return $this->execute(new UserCreateEndpoint(), [
			'clientId' => $clientId,
			'name' => $name,
			'email' => $email,
			'isActive' => $isActive,
		]);
	}

	public function userUpdate($clientId, $name, $email, $isActive)
	{
		return $this->execute(new UserUpdateEndpoint(), [
			'clientId' => $clientId,
			'name' => $name,
			'email' => $email,
			'isActive' => $isActive,
		]);
	}

	public function userGet($clientId, $email)
	{
		return $this->execute(new UserGetEndpoint(), [
			'clientId' => $clientId,
			'email' => $email,
		]);
	}

	public function userGetList($clientId, $orderBy, $limit, $page)
	{
		return $this->execute(new UserGetListEndpoint(), [
			'clientId' => $clientId,
			'orderBy' => $orderBy,
			'limit' => $limit,
			'page' => $page,
		]);
	}

	public function projectAddUser($clientId, $userId, $projectId)
	{
		return $this->execute(new ProjectAddUserEndpoint(), [
			'clientId' => $clientId,
			'userId' => $userId,
			'projectId' => $projectId,
		]);
	}

	public function projectRemoveUser($clientId, $userId, $projectId)
	{
		return $this->execute(new ProjectRemoveUserEndpoint(), [
			'clientId' => $clientId,
			'userId' => $userId,
			'projectId' => $projectId,
		]);
	}

	public function projectHasUserAccess($clientId, $userId, $projectId)
	{
		return $this->execute(new ProjectHasUserAccessEndpoint(), [
			'clientId' => $clientId,
			'userId' => $userId,
			'projectId' => $projectId,
		]);
	}

	public function projectGetUsersForProject($clientId, $projectId, $limit, $page)
	{
		return $this->execute(new ProjectGetUserForProjectEndpoint(), [
			'clientId' => $clientId,
			'projectId' => $projectId,
			'limit' => $limit,
			'page' => $page,
		]);
	}

	public function projectGetProjectsForUser($clientId, $userId, $limit, $page)
	{
		return $this->execute(new ProjectGetProjectsForUserEndpoint(), [
			'clientId' => $clientId,
			'userId' => $userId,
			'limit' => $limit,
			'page' => $page,
		]);
	}

	public function notificationCreateListener($clientId, $sourceId)
	{
		return $this->execute(new NotificationCreateListenerEndpoint($this->notificationListener), [
			'clientId' => $clientId,
			'sourceId' => $sourceId,
		]);
	}

	public function notificationRemoveListener($clientId, $sourceId)
	{
		return $this->execute(new NotificationRemoveListenerEndpoint($this->notificationListener), [
			'clientId' => $clientId,
			'sourceId' => $sourceId,
		]);
	}

	public function notificationRemoveAllListenersByClientId($clientId)
	{
		return $this->execute(new NotificationRemoveAllListenersByClientIdEndpoint($this->notificationListener), [
			'clientId' => $clientId,
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

$methods = new EndpointsHandler(
	new NotificationListenerRepository('redis', 6379)
);
$server = new JsonRpc\Server($methods);
$server->setObjectsAsArrays();
$server->receive();
