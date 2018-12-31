<?php
namespace WebCore\Validation\Loader;


use Narrator\INarrator;
use WebCore\IWebRequest;


class ScalarLoader
{
	/** @var IWebRequest */
	private $request;
	
	
	private function strict(\ReflectionParameter $p)
	{
		$name = $p->getName();
		$params = $this->request->getParams();
		
		switch ($p->getType())
		{
			case 'int':
				return $params->requireInt($name);
				
			case 'bool':
				return $params->requireBool($name);
				
			case 'float':
			case 'double':
				return $params->requireFloat($name);
			
			case 'string':
			default:
				return $params->require($name);
		}
	}
	
	private function optional(\ReflectionParameter $p)
	{
		$name = $p->getName();
		$default = $p->getDefaultValue();
		$params = $this->request->getParams();
		
		switch ($p->getType())
		{
			case 'int':
				return $params->int($name, $default);
				
			case 'bool':
				return $params->bool($name, $default);
				
			case 'float':
			case 'double':
				return $params->float($name, $default);
			
			case 'string':
			default:
				return $params->string($name, $default);
		}
	}
	
	
	public function __construct(IWebRequest $request)
	{
		$this->request = $request;
	}
	
	
	public function get(\ReflectionParameter $p, bool &$isFound)
	{
		$isFound = false;
		
		if ($p->getClass() || !$p->getType())
			return null;
		
		$isFound = true;
		
		return $p->isOptional() ? 
			$this->optional($p) : 
			$this->strict($p);
	}
	
	
	public static function register(INarrator $narrator, IWebRequest $request): void
	{
		$narrator->params()->addCallback([new ScalarLoader($request), 'get']);
	}
}