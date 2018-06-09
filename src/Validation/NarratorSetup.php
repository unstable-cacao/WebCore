<?php
namespace WebCore\Validation;


use Narrator\Narrator;
use WebCore\Base\Input\IInputContainer;
use WebCore\IInput;
use WebCore\IRequest;
use WebCore\RequestInput;


class NarratorSetup
{
	public function create(IInputContainer $container): Narrator
	{
		$narrator = new Narrator();
		$params = $narrator->params();
		
		$params
			->byType(RequestInput::class, $container->getRequestInput())
			->byType(IRequest::class, $container->getRequest())
			->byType(IInput::class, 
				function () use ($container) 
				{ 
					return $container->getInputSource(); 
				})
			->bySubType(
				InputValidator::class, 
				function ()
				{
					
				});
	}
}