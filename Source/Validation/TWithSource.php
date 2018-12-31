<?php
namespace WebCore\Validation;


use WebCore\Base\Validation\IWithSource;
use WebCore\IInput;


trait TWithSource
{
	private $_source = null;
	
	
	private function source(IInput $default): IInput
	{
		return ($this->_source ? $this->_source : $default);
	}
	
	
	/**
	 * @param IInput $source
	 * @return IWithSource|static
	 */
	public function setSource(IInput $source): IWithSource
	{
		$this->_source = $source;
		return $this;
	}
}