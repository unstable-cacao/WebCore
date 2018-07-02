<?php
namespace WebCore\HTTP\Utilities;


use Objection\TStaticClass;
use WebCore\IWebRequest;


class UserAgentExtractor
{
	use TStaticClass;

	
	public static function get(IWebRequest $request, ?string $default): ?string 
	{
		if ($request->hasHeader('User-Agent'))
			return $request->getHeader('User-Agent');
		
		if (isset($_SERVER['HTTP_USER_AGENT']))
			return $_SERVER['HTTP_USER_AGENT'];
		
		return $default;
	}
}