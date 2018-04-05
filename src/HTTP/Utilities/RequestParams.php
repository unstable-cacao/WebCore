<?php

namespace WebCore\HTTP\Utilities;


use Objection\TStaticClass;


class RequestParams
{
	use TStaticClass;
	
	
	private static $params = null;
	
	
	public static function get(): array 
	{
		if (is_null(self::$params))
			self::$params = array_merge($_GET, $_POST);
		
		return self::$params;
	}
}