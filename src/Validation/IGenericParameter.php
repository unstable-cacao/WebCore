<?php
namespace WebCore\Validation;


use WebCore\IInput;


interface IGenericParameter
{
	/**
	 * @param null|IInput $source
	 * @return mixed
	 */
	public static function get(?IInput $source = null);
	
	/**
	 * @param IInput|null $source
	 * @return mixed
	 */
	public static function tryGet(?IInput $source = null);
}