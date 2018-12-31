<?php
namespace WebCore\Validation\Loader;


use Narrator\INarrator;

use WebCore\IInput;
use WebCore\IWebRequest;
use WebCore\Exception\UnexpectedInputParameterName;


class InputLoader
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
		
		if (!$class || $class->getName() != IInput::class)
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
			case 'input':
				return $this->request->getParams();
			
			default:
				throw new UnexpectedInputParameterName($p->getName());
		}
	}
	
	
	public static function register(INarrator $narrator, IWebRequest $request): void
	{
		$narrator->params()->addCallback([new InputLoader($request), 'get']);
	}
}