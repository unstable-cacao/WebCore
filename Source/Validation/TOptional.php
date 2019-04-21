<?php
namespace WebCore\Validation;


use WebCore\Base\Validation\IOptional;


trait TOptional
{
	private $_isOptional = true;
	private $_default = null;
	
	
	private function isOptional(): bool
	{
		return $this->_isOptional;
	}
	
	private function getDefault()
	{
		return $this->_default;
	}
	
	
	/**
	 * @param bool $isRequired
	 * @return IOptional|static
	 */
	public function required(bool $isRequired = true): IOptional
	{
		$this->_isOptional = !$isRequired;
		return $this;
	}
	
	/**
	 * @param bool $isOptional
	 * @return IOptional|static
	 */
	public function optional(bool $isOptional = true): IOptional
	{
		$this->_isOptional = $isOptional;
		return $this;
	}
	
	/**
	 * @param mixed $value
	 * @return IOptional|static
	 */
	public function default($value): IOptional
	{
		$this->_default = $value;
		return $this;
	}
}