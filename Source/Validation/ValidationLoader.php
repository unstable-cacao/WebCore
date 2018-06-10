<?php
namespace WebCore\Validation;


use Narrator\Narrator;

use Skeleton\Skeleton;
use Skeleton\Base\ISkeletonSource;

use WebCore\IWebRequest;
use WebCore\Base\Validation\IValidationLoader;
use WebCore\Validation\Loader\InputLoader;
use WebCore\Validation\Loader\ScalarLoader;
use WebCore\Validation\Loader\PassedParamsLoader;


class ValidationLoader implements IValidationLoader
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
		$skeleton->enableKnot();
		$skeleton->set(IValidationLoader::class, $this);
		
		$this->skeleton = $skeleton;
	}


	/**
	 * @param mixed|string $validator
	 * @return mixed
	 */
	public function load($validator)
	{
		return $this->skeleton->load($validator);
	}
	
	public function invoke($object, string $method, array $args = [])
	{
		$this->getNarrator($args)->invoke([$object, $method]);
	}
}