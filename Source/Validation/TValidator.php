<?php
namespace WebCore\Validation;


use Structura\Arrays;
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
	
	
	private function invoke($args = [])
	{
		return $this->_loader->invoke($this, 'validate', Arrays::toArray($args));
	}
}