<?php
namespace WebCore\Validation\Loader;


use Narrator\INarrator;


class PassedParamsLoader
{
	/** @var array */
	private $params;
	
	
	/**
	 * @param array $passedArgs
	 */
	public function setParams(array $passedArgs)
	{
		$this->params = $passedArgs;
	}


	public function get(\ReflectionParameter $p, bool &$isFound)
	{
		$isFound = false;
		$index = $p->getPosition();
		
		if ($index >= count($this->params))
			return null;
		
		$isFound = true;
		
		return $this->params[$index];
	}
	
	
	public static function register(INarrator $narrator, array $passedArgs): void
	{
		$narrator->params()->addCallback([new PassedParamsLoader($passedArgs), 'get']);
	}
}