<?php
namespace WebCore\HTTP\Utilities;


use Traitor\TStaticClass;


class HeadersLoader
{
	use TStaticClass;

	
	private const UNIQUE_HEADERS = [
        'CONTENT_LENGTH',
        'CONTENT_TYPE',
		'REMOTE_ADDR'
    ];
	
	
	private static $exactHeaders = null;
	private static $lowerCaseHeaders = null;
	
	
	public static function getAllHeaders(bool $caseSensitive = false): array 
	{
		if (!is_null(self::$exactHeaders))
			return $caseSensitive ? self::$exactHeaders : self::$lowerCaseHeaders;
		
		if (function_exists('apache_request_headers'))
		{
			self::$exactHeaders = apache_request_headers();
			
		}
		else if (isset($_SERVER))
		{
			$headers = [];
			$lowercaseHeaders = [];
			
			foreach ($_SERVER as $key => $value)
			{
				if (strlen($key) > 5 && substr($key, 0, 5) == 'HTTP_')
				{
					$key = substr($key, 5);
					$headers[$key] = $value;
					$lowercaseHeaders[strtolower($key)] = $value;
				}
			}
			
			foreach (self::UNIQUE_HEADERS as $special)
			{
				if (isset($_SERVER[$special]))
				{
					$headers[$special] = $_SERVER[$special];
					$lowercaseHeaders[strtolower($special)] = $_SERVER[$special];
				}
			}
			
			self::$exactHeaders = $headers;
			self::$lowerCaseHeaders = $lowercaseHeaders;
		}
		else
		{
			self::$exactHeaders = [];
			self::$lowerCaseHeaders = [];
		}
		
		return $caseSensitive ? self::$exactHeaders : self::$lowerCaseHeaders;
	}
}