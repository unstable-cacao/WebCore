<?php
namespace WebCore\Base\Input;


use WebCore\IInput;
use WebCore\IWebRequest;


interface IInputContainer
{
	public function getRequest(): IWebRequest;
	public function getInputSource(): IInput;
}