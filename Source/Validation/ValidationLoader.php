<?php
namespace WebCore\Validation;


use Skeleton\Skeleton;
use Narrator\Narrator;
use Skeleton\Base\ISkeletonSource;

use WebCore\Base\Validation\IValidationLoader;
use WebCore\IWebRequest;
use WebCore\Validation\Loader\InputLoader;
use WebCore\Validation\Loader\PassedParamsLoader;
use WebCore\Validation\Loader\ScalarLoader;


class ValidationLoader
{
	/** @var Narrator */
	private $narrator = null;
	
	/** @var ISkeletonSource */
	private $skeleton;
	
	/** @var IWebRequest */
	private $request;
	
	/** @var PassedParamsLoader */
	private $paramsLoader;
	
	
	private function getNarrator(array $args = []): Narrator
	{
		if (!$this->narrator)
		{
			$this->paramsLoader = new PassedParamsLoader();
			
			$this->narrator = new Narrator();
			$this->narrator->params()
				->fromSkeleton($this->skeleton)
				->byType(IWebRequest::class, $this->request)
				->addCallback([$this->paramsLoader, 'get'])
				->addCallback([new InputLoader($this->request), 'get'])
				->addCallback([new ScalarLoader($this->request), 'get']);
		}
		
		$this->paramsLoader->setParams($args);
		
		return $this->narrator;
	}
	
	
	public function __construct(IWebRequest $request)
	{
		$this->request = $request;
		
		$skeleton = new Skeleton();
		$skeleton->useGlobal();
		$skeleton->set(IValidationLoader::class, $this);
	}


	public function invoke($object, $method, array $args = [])
	{
		$this->getNarrator($args)->invoke([$object, $method]);
	}
}