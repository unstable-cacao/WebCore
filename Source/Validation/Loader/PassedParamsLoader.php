<?php
namespace WebCore\Validation\Loader;


use WebCore\Base\Validation\IParamsLoader;


class PassedParamsLoader implements IParamsLoader
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
}