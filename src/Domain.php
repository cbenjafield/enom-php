<?php

namespace Benjafield\Enom;

class Domain {

	protected $enom;
	protected $client;

	public function __construct(Enom $enom)
	{
		$this->enom = $enom;
		$this->client = $enom->getClient();
	}

}