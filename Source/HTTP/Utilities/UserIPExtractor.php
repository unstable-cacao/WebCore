<?php
namespace WebCore\HTTP\Utilities;


use Traitor\TStaticClass;
use WebCore\IWebRequest;


class UserIPExtractor
{
	use TStaticClass;
	
	
	public static function get(IWebRequest $request, ?string $default): ?string
	{
		if ($request->hasHeader('CLIENT_IP'))
			return $request->getHeader('CLIENT_IP');
		
		if ($request->hasHeader('X_FORWARDED_FOR'))
		{
			$ips = explode(',', $request->getHeader('X_FORWARDED_FOR'));
			return trim($ips[0]);
		}
		
		if ($request->hasHeader('REMOTE_ADDR'))
			return $request->getHeader('REMOTE_ADDR');
		
		return $default;
	}
}