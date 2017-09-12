<?php
namespace WebCore\Validation;


use WebCore\Input;
use WebCore\IInput;
use WebCore\Exception\BadRequestException;


class AbstractValidator
{
	protected static function null()
	{
		return NullValue::NULL();
	}
	
	protected static function getSource(?IInput $source): IInput
	{
		return $source ?: Input::params();
	}

	/**
	 * @param IInput|null $source
	 * @return static
	 */
	protected static function getObjects(?IInput &$source)
	{
		$source = $source ?: Input::params();
		return new static();
	}
	
	/**
	 * @param mixed $result
	 * @return mixed
	 */
	protected static function requireResult($result)
	{
		if (is_null($result))
			throw new BadRequestException(/** TODO: appropriate error **/);
		
		return NullValue::is($result) ? null : $result;
	}

	/**
	 * @param mixed $result
	 * @return mixed
	 */
	public static function getResult($result)
	{
		return NullValue::is($result) ? null : $result;
	}
}