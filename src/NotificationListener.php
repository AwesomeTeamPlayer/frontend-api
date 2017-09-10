<?php

class NotificationListener
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

	public function addListener(
		string $clientId,
		string $sourceId
	)
	{
		$this->redis->lPush($sourceId, $clientId);
	}

	public function removeListener(
		string $clientId,
		string $sourceId
	)
	{
		$this->redis->lRem($sourceId, $clientId, 0);
	}

}
