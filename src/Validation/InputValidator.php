<?php
namespace WebCore\Validation;


use WebCore\IInput;
use WebCore\IRequest;
use WebCore\IRequestInput;
use WebCore\Base\Input\IInputContainer;


class InputValidator
{
	/** @var IInputContainer */
	private $container;
	
	
	protected function getRequest(): IRequest
	{
		return $this->container->getRequest();
	}
	
	protected function getInputSource(): IInput
	{
		return $this->container->getInputSource();
	}

	protected function getRequestInput(): IRequestInput
	{
		return $this->container->getRequestInput();
	}
	
	
	public function __construct(IInputContainer $container)
	{
		$this->container = $container;
	}
}