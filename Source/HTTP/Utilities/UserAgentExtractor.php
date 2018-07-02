<?php
namespace WebCore\HTTP\Utilities;


use Traitor\TStaticClass;
use WebCore\IWebRequest;


class UserAgentExtractor
{
	use TStaticClass;

	
	public static function get(IWebRequest $request, ?string $default): ?string 
	{
		if ($request->hasHeader('USER_AGENT'))
			return $request->getHeader('USER_AGENT');
		
		if (isset($_SERVER['HTTP_USER_AGENT']))
			return $_SERVER['HTTP_USER_AGENT'];
		
		return $default;
	}
}