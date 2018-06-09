<?php
namespace WebCore\Validation;


use WebCore\Base\Validation\IValidationLoader;


trait TValidator
{
	private $_loader;
	
	
	private function loader(): IValidationLoader
	{
		return $this->_loader;
	}
	
	
	public function __construct(IValidationLoader $loader)
	{
		$this->_loader = $loader;
	}
	
	
	private function invoke(array $args = [])
	{
		return $this->_loader->invoke([$this, 'validate'], $args);
	}
}