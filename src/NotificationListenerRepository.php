<?php

class NotificationListenerRepository
{
	/**
	 * @var Redis
	 */
	private $redis;

	public function __construct(string $host, int $port)
	{
		$this->redis = new Redis();
		$this->redis->connect($host, $port);
	}

	public function addListener(string $clientId, string $sourceId)
	{
		$this->redis->lPush('source-' . $sourceId, $clientId);
		$this->redis->lPush($clientId, $sourceId);
	}

	public function removeListener(string $clientId, string $sourceId)
	{
		$this->redis->lRem('source-' . $sourceId, $clientId, 0);
		$this->redis->lRem($clientId, $sourceId, 0);

		if ($this->redis->lLen('source-' . $sourceId) === 0) {
			$this->redis->del('source-' . $sourceId);
		}

		if ($this->redis->lLen($clientId) === 0) {
			$this->redis->del($clientId);
		}
	}

	public function removeListenerByClientId(string $clientId)
	{
		$sourceIds = $this->redis->lRange($clientId, 0, -1);
		foreach ($sourceIds as $sourceId) {
			$this->removeListener($clientId, $sourceId);
		}
	}

}
