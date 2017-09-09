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
		// TODO
	}
	
	public static function params(): IInput
	{
		// Get parameters based on the current request method 
	}
	
	public static function method(): string
	{
		
	}
}