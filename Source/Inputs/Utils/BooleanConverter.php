<?php
namespace WebCore\Inputs\Utils;


use Traitor\TStaticClass;


class BooleanConverter
{
	use TStaticClass;
	
	
	private const FALSE_OPTIONS = [
			'' 		=> '',
			'0' 	=> '',
			'false' => '',
			'f' 	=> '',
			'off' 	=> ''
	];
	
	
	public static function get(string $source): bool 
	{
		return !key_exists($source, self::FALSE_OPTIONS);
	}
}