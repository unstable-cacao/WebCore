<?php
namespace WebCore\Exception;


use Exception;

class WebServerException extends \Exception
{
	private $userMessage;
	
	
	public function __construct($code, $userMessage = null, $message = "", Exception $previous = null)
	{
		// TODO:
	}
	
	
	public function getUserMessage()
	{
		// TODO:
	}
}