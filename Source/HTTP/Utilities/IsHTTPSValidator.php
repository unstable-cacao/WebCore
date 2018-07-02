<?php
namespace WebCore\HTTP\Utilities;


use Traitor\TStaticClass;


class IsHTTPSValidator
{
	use TStaticClass;

	
	private static $isHttps = null;
	
	
	public static function isHttps(): bool 
	{
		if (!is_null(self::$isHttps))
			return self::$isHttps;
		
		if (isset($_SERVER['SERVER_PROTOCOL']))
		{
			self::$isHttps = (strtolower(substr($_SERVER['SERVER_PROTOCOL'], 0, 5)) == 'https');
		}
		else if (isset($_SERVER['HTTPS']))
		{
			self::$isHttps = (strtolower($_SERVER['HTTPS']) != 'off');
		}
		else 
		{
			self::$isHttps = false;
		}
		
		return self::$isHttps;
	}
}