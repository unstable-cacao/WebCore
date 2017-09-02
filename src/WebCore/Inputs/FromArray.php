<?php
namespace WebCore\Inputs;


use WebCore\IInput;


class FromArray implements IInput
{
	private $source;
	
	
	public function __construct(array $source)
	{
		$this->source = $source;
	}
}