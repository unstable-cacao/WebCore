<?php
namespace WebCore\Validation;


class NullValue
{
	private static $null;
	
	
	public static function is($value): bool
	{
		return $value === self::NULL();
	}
	
	public static function NULL()
	{
		if (!self::$null)
			self::$null = new \stdClass();
		
		return self::$null;
	}
}