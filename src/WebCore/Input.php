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
        // TODO
    }
    
    public static function session(): IInput
    {
        return new FromArray($_SESSION);
    }
    
    public static function params(): IInput
    {
        // Get parameters based on the current request method 
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