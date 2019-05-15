<?php

namespace Benjafield\Enom;

use GuzzleHttp\Client;

class Enom {

	protected $client;
	protected $baseUrl = 'https://resellertest.enom.com/interface.asp';

	public function __construct($username, $password)
	{
		$this->client = new Client([
			'base_url' => $this->baseUrl,
			'defaults' => [
				'query' => [
					'UID' => $username,
					'PW' => $password,
					'ResponseType' => 'xml'
				]
			]
		]);
	}

	public function getClient()
	{
		return $this->client;
	}

}