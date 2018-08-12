<?php
namespace WebCore\HTTP\Requests;


use WebCore\IInput;
use WebCore\Method;
use WebCore\IWebRequest;
use WebCore\HTTP\Utilities;
use WebCore\Base\HTTP\IRequestFiles;
use WebCore\Inputs\FromArray;
use WebCore\Exception\WebCoreFatalException;
use WebCore\Validation\ValidationLoader;


class StandardWebRequest implements IWebRequest
{
	private static $current = null;
	
	
	private $headers	= null;
	private $isHttps	= null;
	private $method		= null;
	private $params		= null;
	private $body		= null;
	
	/** @var ValidationLoader */
	private $validation = null;
	
	
	public function isMethod(string $method): bool { return $this->getMethod() == $method; }
	public function isGet(): bool { return $this->getMethod() == Method::GET; }
	public function isPost(): bool { return $this->getMethod() == Method::POST; }
	public function isPut(): bool { return $this->getMethod() == Method::PUT; }
	public function isDelete(): bool { return $this->getMethod() == Method::DELETE; }
	
	public function isHttp(): bool { return !$this->isHttps(); }
	
	
	public function getHeaders(): IInput { return new FromArray($this->getHeadersArray()); }
	public function getHeader(string $header, ?string $default = null): ?string { return $this->getHeaders()->string($header, $default); }
	public function hasHeader(string $header): bool { return $this->getHeaders()->has($header); }
	
	public function getCookies(): IInput { return new FromArray($this->getCookiesArray()); }
	public function getCookiesArray(): array { return $_COOKIE;	}
	public function getCookie(string $cookie, ?string $default = null): ?string { return $this->getCookies()->string($cookie, $default); }
	public function hasCookie(string $cookie): bool { return $this->getCookies()->has($cookie); }
	
	public function getParams(): IInput { return new FromArray($this->getParamsArray()); }
	public function getParam(string $param, ?string $default = null): ?string { return $this->getParams()->string($param, $default); }
	public function hasParam(string $param): bool { return $this->getParams()->has($param); }
	
	public function getQuery(): IInput { return new FromArray($this->getQueryArray()); }
	public function getQueryArray(): array { return $_GET; }
	public function getQueryParam(string $param, ?string $default = null): ?string { return $this->getQuery()->string($param, $default); }
	public function hasQueryParam(string $param): bool { return $this->getQuery()->has($param); } 
	
	public function getPost(): IInput { return new FromArray($this->getPostArray()); }
	public function getPostArray(): array { return $_POST; }
	public function getPostParam(string $param, ?string $default = null): ?string { return $this->getPost()->string($param, $default); }
	public function hasPostParam(string $param): bool { return $this->getPost()->has($param); }
	
	
	public function getMethod(): string
	{
		if (is_null($this->method))
			$this->method = $_SERVER['REQUEST_METHOD'] ?? Method::UNKNOWN;
		
		return $this->method;
	}
	
	public function isHttps(): bool
	{
		if (is_null($this->isHttps))
			$this->isHttps = Utilities::isHTTPSRequest();
		
		return $this->isHttps;
	}
	
	public function getUserAgent(?string $default = null): ?string
	{
		return Utilities\UserAgentExtractor::get($this, $default);
	}
	
	public function getHeadersArray(): array
	{
		if (is_null($this->headers))
			$this->headers = Utilities::getAllHeaders();
		
		return $this->headers;
	}
	
	public function getParamsArray(): array
	{
		if (is_null($this->params))
		{
			switch ($this->getMethod())
			{
				case Method::POST:
					$this->params = self::getPostArray();
					break;
					
				case Method::PUT:
					parse_str($this->getBody(), $this->params);
					break;
					
				case Method::GET:
				case Method::OPTIONS:
				case Method::HEAD:
				case Method::DELETE:
				default:
					$this->params = $this->getQueryArray();
					break;
			}
		}
		
		return $this->params;
	}
	
	public function getPort(): ?int
	{
		if (!isset($_SERVER['SERVER_PORT']))
			return null;
		
		return (int)$_SERVER['SERVER_PORT'];
	}
	
	public function getHost(): string
	{
		return $_SERVER['HTTP_HOST'] ?? '';
	}
	
	public function getIP(?string $default = null): string
	{
		return Utilities\UserIPExtractor::get($this, $default) ?: '';
	}
	
	public function getURI(): string
	{
		return $_SERVER['REQUEST_URI'] ?? '';
	}
	
	public function getURL(): string
	{
		$protocol = $this->isHttp() ? 'http' : 'https';
		return "{$protocol}://" . $this->getHost() . $this->getURI();
	}
	
	
	public function files(): ?IRequestFiles
	{
		// TODO:
		return null;
	}
	
	public function hasFiles(): bool
	{
		// TODO:
		return false;
	}
	
	public function getBody(): string
	{
		if (is_null($this->body))
			$this->body = stream_get_contents(STDIN);
		
		return $this->body;
	}
	
	public function getJson(): array
	{
		$body = $this->getBody();
		$json = jsondecode($body, JSON_OBJECT_AS_ARRAY);
		
		if (json_last_error() != 0)
			throw new WebCoreFatalException('Request body is not a valid json');
		
		return $json;
	}
	
	/**
	 * @param $validator
	 * @return mixed
	 */
	public function getValidator($validator)
	{
		if (is_null($this->validation))
			$this->validation = new ValidationLoader($this);
		
		return $this->validation->load($validator);
	}
	
	
	public static function current(): StandardWebRequest
	{
		if (!self::$current)
			self::$current = new static();
		
		return self::$current;
	}
}