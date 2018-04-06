<?php
namespace WebCore;


use WebCore\HTTP\Requests\StandardRequest;
use WebCore\Inputs\FromArray;


class RequestInput implements IRequestInput
{
	/** @var IRequestInput */
	private static $current;
	
	
	/** @var IRequest */
	private $request;
	
	
	public function __construct(IRequest $request)
	{
		$this->request = $request;
	}


	public function get(): IInput
	{
		return new FromArray($this->request->getParams());
	}
	
	public function post(): IInput
	{
		return new FromArray($this->request->getPostParams());
	}
	
	public function cookies(): IInput
	{
		return new FromArray($this->request->getCookies());
	}
	
	public function headers(): IInput
	{
		return new FromArray($this->request->getHeaders());
	}
	
	public function params(): IInput
	{
		switch ($this->request->getMethod())
		{
			case Method::POST:
				return self::post();
				
			case Method::PUT:
				parse_str($this->request->getBody(), $params);
				return new FromArray($params);
				
			case Method::GET:
			case Method::OPTIONS:
			case Method::HEAD:
			case Method::DELETE:
			default:
				return self::get();
		}
	}
	
	public function method(): string
	{
		return $this->request->getMethod();
	}

	public function request(): IRequest
	{
		return $this->request;
	}
	
	
	public static function current(?IRequestInput $value = null): IRequestInput
	{
		if ($value)
			self::$current = $value;
		else if (!self::$current)
			self::$current = new static(StandardRequest::current());
		
		return self::$current;
	}
}