<?php
namespace WebCore\HTTP;


use Objection\TStaticClass;
use WebCore\HTTP\Utilities\HeadersLoader;
use WebCore\HTTP\Utilities\RequestParams;
use WebCore\HTTP\Utilities\IsHTTPSValidator;


class Utilities
{
	use TStaticClass;
	
	
	public static function getAllHeaders(): array
	{
		return HeadersLoader::getAllHeaders();
	}
	
	public static function isHTTPSRequest(): bool
	{
		return IsHTTPSValidator::isHttps();
	}

	/**
	 * Get the GET and POST params in one array.
	 * @return array
	 */
	public static function getAllParams(): array 
	{
		return RequestParams::get();
	}
}