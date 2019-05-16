<?php

namespace Benjafield\Enom;

class Resource {

	protected $attributes = [];

	public function __construct($data = [])
	{
		if(!empty($data))
		{
			$this->attributes = $data;
		}
	}

	public function __isset($name)
	{
		return !!isset($this->attributes[$name]);
	}

	public function __set($name, $value)
	{
		$this->attributes[$name] = $value;
	}

	public function __get($name)
	{
		return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
	}

	public function all()
	{
		return $this->attributes;
	}

}