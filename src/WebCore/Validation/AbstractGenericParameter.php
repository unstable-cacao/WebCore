<?php
namespace WebCore\Validation;


use WebCore\IInput;


abstract class AbstractGenericParameter extends AbstractValidator implements IGenericParameter
{
	/**
	 * @param IInput $input
	 * @return mixed
	 */
	protected abstract function validateAndGet(IInput $input);
	
	
	/**
	 * @param null|IInput $source
	 * @return mixed
	 */
	public static function get(?IInput $source = null)
	{
		$instance = self::getObjects($source);
		return self::requireResult($instance->validateAndGet($source));
	}

	/**
	 * @param IInput|null $source
	 * @return mixed
	 */
	public static function tryGet(?IInput $source = null)
	{
		$instance = self::getObjects($source);
		return self::getResult($instance->validateAndGet($source));
	}
}