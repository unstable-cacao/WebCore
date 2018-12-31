<?php
namespace WebCore\Base\Validation;


interface IOptional
{
	/**
	 * @param bool $isRequired
	 * @return IOptional|static
	 */
	public function required(bool $isRequired = true): IOptional;
	
	/**
	 * @param bool $isOptional
	 * @return IOptional|static
	 */
	public function optional(bool $isOptional = true): IOptional;
	
	/**
	 * @param mixed $value
	 * @return IOptional|static
	 */
	public function default($value): IOptional;
}