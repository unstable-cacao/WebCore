<?php
namespace WebCore;


use Traitor\TEnum;


class SameSite
{
	use TEnum;
	
	
	public const NONE	= 'None';
	public const STRICT	= 'Strict';
	public const LAX	= 'Lax';
}