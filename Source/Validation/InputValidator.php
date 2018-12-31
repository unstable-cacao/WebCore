<?php
namespace WebCore\Validation;


use Structura\Strings;
use WebCore\Base\Validation\IInputValidator;
use Narrator\INarrator;


abstract class InputValidator implements IInputValidator
{
	/** @var INarrator */
	private $narrator;
	
	
	public function setNarrator(INarrator $narrator): void
	{
		$this->narrator = $narrator;
	}
	
	
	protected function invokeExecute(string $on = 'execute')
	{
		$narrator = clone $this->narrator;
		
		if (!Strings::isStartsWith($on, 'execute'))
		{
			$optionalName = 'execute' . ucfirst($on);
			
			if (is_callable([$this, $optionalName]))
			{
				$on = $optionalName;
			}
		}
		
		for ($index = 1; $index < func_num_args(); $index++)
		{
			$narrator->params()->atPosition($index - 1, func_get_arg($index));
		}
		
		return $narrator->invoke([$this, $on]);
	}
}