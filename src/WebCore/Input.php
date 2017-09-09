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
		return Method::isExists($method) ? $method : Method::UNKNOWN;
	}
	
	public static function isGet(string $method): bool 
	{
		return $method == Method::GET;
	}
	
	public static function isHead(string $method): bool 
	{
		return $method == Method::HEAD;
	}
	
	public static function isPost(string $method): bool 
	{
		return $method == Method::POST;
	}
	
	public static function isPut(string $method): bool 
	{
		return $method == Method::PUT;
	}
	
	public static function isDelete(string $method): bool 
	{
		return $method == Method::DELETE;
	}
	
	public static function isOptions(string $method): bool 
	{
		return $method == Method::OPTIONS;
	}
}