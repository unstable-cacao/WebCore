<?php
namespace WebCore;


use Objection\TEnum;


class Method
{
	use TEnum;
	
	// https://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html
	
	const GET 		= 'GET';
	const HEAD 		= 'HEAD';
	const POST 		= 'POST';
	const PUT 		= 'PUT';
	const DELETE 	= 'DELETE';
	const OPTIONS 	= 'OPTIONS';
	const UNKNOWN 	= 'UNKNOWN';
}