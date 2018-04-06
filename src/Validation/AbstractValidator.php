<?php
namespace WebCore\Validation;


use Skeleton\Skeleton;

use WebCore\RequestInput;
use WebCore\IInput;
use WebCore\Exception\BadRequestException;


class AbstractValidator
{
	private static $skeleton;
	
	
	private static function getSkeleton(): Skeleton
	{
		if (!self::$skeleton)
		{
			self::$skeleton = new Skeleton();
			self::$skeleton
				->useGlobal()
				->enableKnot();
		}
		
		return self::$skeleton;
	}
	
	
	protected static function null()
	{
		return NullValue::NULL();
	}
	
	protected static function getSource(?IInput $source): IInput
	{
		return $source ?: RequestInput::params();
	}

	/**
	 * @param IInput|null $source
	 * @return static
	 */
	protected static function getObjects(?IInput &$source)
	{
		$source = $source ?: RequestInput::params();
		$instance = new static();
		return self::getSkeleton()->load($instance);
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