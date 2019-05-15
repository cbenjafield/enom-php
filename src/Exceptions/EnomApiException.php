<?php

namespace Benjafield\Enom\Exceptions;

use Exception;

class EnomApiException extends Exception {

	protected $errors;

	public function __construct($errors = null)
	{
		$this->errors = $errors;
	}

	public function getErrors()
	{
		return $this->errors;
	}

}