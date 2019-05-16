<?php

namespace Benjafield\Enom;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use SimpleXMLElement;

class Request {

	protected $client;
	protected $container = [];
	protected $history;
	protected $stack;
	protected $enom;
	protected $debug = [];

	public function __construct($enom)
	{
		$this->enom = $enom;
		$this->history = Middleware::history($this->container);
		$this->stack = HandlerStack::create();
		$this->stack->push($this->history);

		$this->client = new Client([
			'handler' => $this->stack,
			'base_uri' => $this->enom->getBaseUri()
		]);
	}

	public function getClient()
	{
		return $this->client;
	}

	public function get($command, $params = [])
	{
		$params = array_merge($this->enom->getDefaultQuery(), [
			'Command' => $command
		], $params);

		$response = $this->client->request('GET', '', [
			'query' => $params
		]);

		return $response;
	}

	public function parseXml($response, $simpleXml = false)
	{
		$xml = new SimpleXMLElement($response->getBody()->getContents());
		if($simpleXml) return $xml;
		return json_decode(json_encode($xml));
	}

}