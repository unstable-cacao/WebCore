<?php
namespace WebCore;


use Traitor\TEnum;


class Method
{
	use TEnum;
	
	
	const GET 		= 'GET';
	const HEAD 		= 'HEAD';
	const POST 		= 'POST';
	const PUT 		= 'PUT';
	const DELETE 	= 'DELETE';
	const OPTIONS 	= 'OPTIONS';
	const UNKNOWN 	= 'UNKNOWN';
}