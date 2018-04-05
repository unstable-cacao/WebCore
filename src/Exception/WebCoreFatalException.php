<?php
namespace WebCore\Exception;


class WebCoreFatalException extends ServerErrorException
{
	public function __construct(string $message = "")
	{
		parent::__construct("Unexpected Error", $message);
	}
}