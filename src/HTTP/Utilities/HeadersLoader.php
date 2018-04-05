<?php
namespace WebCore\HTTP\Utilities;


use Objection\TStaticClass;


class HeadersLoader
{
	use TStaticClass;

	
	private static $headers = null;
	
	
	public static function getAllHeaders(): array 
	{
		if (!is_null(self::$headers))
			return self::$headers;
		
		if (function_exists('apache_request_headers'))
		{
			self::$headers = apache_request_headers();
		}
		else if (isset($_SERVER))
		{
			$headers = [];
			
			foreach ($_SERVER as $key => $value)
			{
				if (strlen($key) > 5 && substr($key, 0, 5) == 'HTTP_')
				{
					$headers[substr($key, 5)] = $value;
				}
			}
			
			self::$headers = $headers;
		}
		else
		{
			self::$headers = [];
		}
		
		return self::$headers;
	}
}