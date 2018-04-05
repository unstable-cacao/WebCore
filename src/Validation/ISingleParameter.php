<?php
namespace WebCore\Validation;


use WebCore\IInput;


interface ISingleParameter
{
	/**
	 * @param string $name
	 * @param null|IInput $source
	 * @return mixed
	 */
	public static function get(string $name, ?IInput $source = null);
	
	/**
	 * @param string $name
	 * @param IInput|null $source
	 * @return mixed
	 */
	public static function tryGet(string $name, ?IInput $source = null);
}