<?php
namespace WebCore\Inputs\Utils;


use Objection\TEnum;
use Objection\TStaticClass;


class InputValidationHelper
{
	use TStaticClass;
	
	
	/**
	 * @param array|string $value
	 * @return bool
	 */
	public static function isInt($value): bool 
	{
		return is_array($value) ? false : $value == (string)((int)$value);
	}
	
	/**
	 * @param array|string $value
	 * @return bool
	 */
	public static function isFloat($value): bool 
	{
		return is_array($value) ? false : $value == (string)((float)$value);
	}
	
	/**
	 * @param array|string $value
	 * @return bool
	 */
	public static function isBool($value): bool 
	{
		return is_string($value);
	}
	
	/**
	 * @param mixed $enumValues
	 * @return bool
	 */
	public static function isEnum($enumValues): bool
	{
		if (is_array($enumValues))
		{
			return true;
		}
		else
		{
			if (!is_string($enumValues) ||
				!class_exists($enumValues) ||
				!key_exists(TEnum::class, class_uses($enumValues)))
			{
				return false;
			}
			else
			{
				return true;
			}
		}
	}
}