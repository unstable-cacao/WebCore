<?php
namespace WebCore\HTTP;


use Traitor\TStaticClass;
use WebCore\HTTP\Utilities\HeadersLoader;
use WebCore\HTTP\Utilities\IsHTTPSValidator;


class Utilities
{
	use TStaticClass;
	
	
	public static function getAllHeaders(bool $caseSensitive = false): array
	{
		return HeadersLoader::getAllHeaders($caseSensitive);
	}
	
	public static function isHTTPSRequest(): bool
	{
		return IsHTTPSValidator::isHttps();
	}
}