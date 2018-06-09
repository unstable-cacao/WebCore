<?php
namespace WebCore\Exception;


use Exception;


class ServerErrorException extends WebServerException
{
	public function __construct($userMessage = null, $message = "", Exception $previous = null)
	{
		parent::__construct(500, $message, $userMessage, $previous);
	}
}