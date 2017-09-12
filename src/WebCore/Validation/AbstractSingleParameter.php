<?php
namespace WebCore\Validation;


use WebCore\IInput;


abstract class AbstractSingleParameter extends AbstractValidator implements ISingleParameter
{
	/**
	 * @param string $param
	 * @param IInput $source
	 * @return mixed
	 */
	protected abstract function validateAndGet(string $param, IInput $source);
	
	
	/**
	 * @param string $name
	 * @param null|IInput $source
	 * @return mixed
	 */
	public static function get(string $name, ?IInput $source = null)
	{
		$instance = self::getObjects($source);
		$result = $instance->validateAndGet($name, $source);
		return self::requireResult($result);
	}

	/**
	 * @param string $name
	 * @param IInput|null $source
	 * @return mixed
	 */
	public static function tryGet(string $name, ?IInput $source = null)
	{
		$instance = self::getObjects($source);
		$result = $instance->validateAndGet($name, $source);
		return self::getResult($result);
	}
}