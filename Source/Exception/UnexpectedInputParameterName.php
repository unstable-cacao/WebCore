<?php

namespace WebCore\Exception;


class UnexpectedInputParameterName extends WebServerException
{
	private const ALLOWED_NAMES = [
		'get',
		'query',
		'post',
		'header',
		'headers',
		'cookie',
		'cookies',
		'params'
	];
	
	
	public function __construct(string $actualName)
	{
		$allowed = implode("', '", self::ALLOWED_NAMES);
		
		parent::__construct(
			500, 
			null, 
			'A name of an auto loaded IInput parameter ' . 
				'inside validators must be one of: ' . 
				"'$allowed'. Instead got: '$actualName'" );
	}
}