<?php
namespace WebCore\Validation\Loader;


use WebCore\Base\Validation\IParamsLoader;
use WebCore\Exception\UnexpectedInputParameterName;
use WebCore\IInput;
use WebCore\IWebRequest;


class InputLoader implements IParamsLoader
{
	/** @var IWebRequest */
	private $request;
	
	
	public function __construct(IWebRequest $request)
	{
		$this->request = $request;
	}


	public function get(\ReflectionParameter $p, bool &$isFound): ?IInput
	{
		$class = $p->getClass();
		$isFound = false;
		
		if (!$class || $class != IInput::class)
			return null;
		
		$isFound = true;
		
		switch (strtolower($p->getName()))
		{
			case 'get':
			case 'query':
				return $this->request->getQuery();
			
			case 'post': 
				return $this->request->getPost();
			
			case 'header':
			case 'headers':
				return $this->request->getHeaders();
			
			case 'cookie':
			case 'cookies':
				return $this->request->getCookies();
				
			case 'params':
				return $this->request->getParams();
			
			default:
				throw new UnexpectedInputParameterName($p->getName());
		}
	}
}