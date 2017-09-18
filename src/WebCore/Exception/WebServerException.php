<?php
namespace WebCore\Exception;


use Exception;

class WebServerException extends \Exception
{
	private $userMessage;
	
	
	public function __construct($code, $userMessage = null, $message = "", Exception $previous = null)
	{
	    parent::__construct($message, $code, $previous);
		$this->userMessage = $userMessage;
	}
	
	
	public function getUserMessage()
	{
		return $this->userMessage;
	}
}