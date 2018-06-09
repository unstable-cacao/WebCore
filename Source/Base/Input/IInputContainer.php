<?php
namespace WebCore\Base\Input;


use WebCore\IInput;
use WebCore\IWebRequest;
use WebCore\IRequestInput;


interface IInputContainer
{
	public function getRequest(): IWebRequest;
	public function getInputSource(): IInput;
	public function getRequestInput(): IRequestInput;
}