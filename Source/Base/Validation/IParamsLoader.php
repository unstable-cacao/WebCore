<?php
namespace WebCore\Base\Validation;


interface IParamsLoader
{
	public function get(\ReflectionParameter $p, bool &$isFound);
}