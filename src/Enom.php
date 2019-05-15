<?php

namespace Benjafield\Enom;

use GuzzleHttp\Client;

class Enom {

	protected $username;
	protected $password;
	protected $baseUri = 'https://resellertest.enom.com/interface.asp';

	public function __construct($username, $password)
	{
		$this->username = $username;
		$this->password = $password;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function getBaseUri()
	{
		return $this->baseUri;
	}

	public function getDefaultQuery()
	{
		return [
			'UID' => $this->username,
			'PW' => $this->password,
			'ResponseType' => 'xml'
		];
	}

}