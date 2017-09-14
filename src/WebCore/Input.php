<?php
namespace WebCore;


use WebCore\Inputs\FromArray;


class Input
{
    public static function get(): IInput
    {
        return new FromArray($_GET);
    }
    
    public static function post(): IInput
    {
        return new FromArray($_POST);
    }
    
    public static function cookies(): IInput
    {
        return new FromArray($_COOKIE);
    }
    
    public static function headers(): IInput
    {
    	$headers = [];
    	
		foreach ($_SERVER as $key => $value) 
		{
			if (strpos($key, 'HTTP_') === 0)
			{
				$headers[substr($key, 5)] = $value;
			}
			else if ($key == 'CONTENT_LENGTH' || $key == 'CONTENT_TYPE')
			{
				$headers[$key] = $value;
			}
        }
        
        return new FromArray($headers);
    }
    
    public static function session(): IInput
    {
        return new FromArray($_SESSION ?? []);
    }
    
    public static function params(): IInput
    {
    	switch (self::method())
		{
			case Method::GET:
			case Method::OPTIONS:
			case Method::HEAD:
			case Method::DELETE:
				return self::get();
			case Method::POST:
				return self::post();
			case Method::PUT:
				parse_str(self::body(), $params);
				return new FromArray($params);
			default:
				return new FromArray([]);
		}
    }
    
    public static function body(): ?string 
	{
		return file_get_contents("php://input");
	}
    
    public static function method(): string
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? '';
        $method = strtoupper($method);
        
        return Method::isExists($method) ? $method : Method::UNKNOWN;
    }
	
	public static function is(string $method): bool 
	{
		return self::method() == $method;
	}
	
	public static function isGet(): bool 
	{
		return self::is(Method::GET);
	}
	
	public static function isHead(): bool 
	{
		return self::is(Method::HEAD);
	}
	
	public static function isPost(): bool 
	{
		return self::is(Method::POST);
	}
	
	public static function isPut(): bool 
	{
		return self::is(Method::PUT);
	}
	
	public static function isDelete(): bool 
	{
		return self::is(Method::DELETE);
	}
	
	public static function isOptions(): bool 
	{
		return self::is(Method::OPTIONS);
	}
}