<?php
namespace WebCore\Exception;


use Exception;


/**
 * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/400
 */
class BadRequestException extends WebServerException
{
	public function __construct($userMessage = 'Bad Request', $message = 'Bad Request', Exception $previous = null)
	{
		parent::__construct(400, $message, $userMessage, $previous);
	}
}