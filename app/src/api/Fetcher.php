<?php

namespace Api;

use GuzzleHttp\Client;

class Fetcher
{
	const API_URL = 'https://jsonplaceholder.typicode.com';

	const ENTITY_INFO = 'entity_info';
	const ENTITY_RELATIONS_COUNT = 'entity_relations_count';

	protected $guzzleClient;

	public function __construct()
	{
		$this->guzzleClient = new Client(['base_uri' => self::API_URL]);
	}

	protected function sendRequest($resource, $method = 'GET')
	{
		return $this->guzzleClient->request(
			$method,
			self::API_URL . $resource
		);
	}

	protected function getResponseAsArray($response)
	{
		if ($response && is_object($response))
		{
			return json_decode($response->getBody()->getContents(), TRUE);
		}
		return NULL;
	}

	public function getEntity($entityType, $entityId)
	{
		$response = $this->sendRequest('/'.$entityType.'s/' . $entityId);
		return $this->getResponseAsArray($response);
	}

	public function getRelations($entityType, $entityId, $entityRelation)
	{
		$response = $this->sendRequest('/'.$entityRelation.'s/?'.$entityType.'Id=' . $entityId);
		return $this->getResponseAsArray($response);
	}

	public function process($entityType, $entityId, $entityRelation) : array
	{
		return [
			self::ENTITY_INFO => $this->getEntity($entityType, $entityId),
			self::ENTITY_RELATIONS_COUNT => count($this->getRelations($entityType, $entityId, $entityRelation))
		];
	}
}