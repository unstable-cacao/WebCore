<?php
namespace WebCore\Validation\Loader;


use Skeleton\Base\ISkeletonSource;
use Skeleton\Exceptions\ImplementerNotDefinedException;

use WebCore\IInput;
use WebCore\Base\Validation\IParamsLoader;


class SkeletonLoader implements IParamsLoader
{
	/** @var ISkeletonSource */
	private $skeleton;
	
	
	public function __construct(ISkeletonSource $request)
	{
		$this->skeleton = $request;
	}
	
	
	public function get(\ReflectionParameter $p, bool &$isFound): ?IInput
	{
		if ($p->getClass())
		{
			$isFound = false;
			return null;
		}
		
		try
		{
			$isFound = true;
			return $this->skeleton->get($p->getClass());
		}
		catch (ImplementerNotDefinedException $e)
		{
			$isFound = false;
			return null;
		}
	}
}