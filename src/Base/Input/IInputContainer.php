<?php
namespace WebCore\Base\Input;


use WebCore\IInput;
use WebCore\IRequest;
use WebCore\IRequestInput;


interface IInputContainer
{
	public function getRequest(): IRequest;
	public function getInputSource(): IInput;
	public function getRequestInput(): IRequestInput;
}