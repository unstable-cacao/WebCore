<?php
namespace WebCore\HTTP\Requests;


use WebCore\Base\HTTP\IRequestFiles;
use WebCore\Base\Validation\IValidationLoader;
use WebCore\Exception\WebCoreFatalException;
use WebCore\IInput;
use WebCore\Inputs\FromArray;
use WebCore\IWebRequest;
use WebCore\Method;
use WebCore\Validation\ValidationLoader;


class DummyWebRequest implements IWebRequest
{
	private static $current = null;
	
	
	private $headers	= [];
	private $isHttps	= false;
	private $method		= Method::GET;
	private $params		= [];
	private $body		= '';
	private $port		= null;
	private $userAgent	= null;
	private $clientIp	= null;
	private $uri		= '';
	private $cookies	= [];
	
	/** @var IValidationLoader */
	private $validation = null;
	
	
	public function __construct(array $params = [], array $headers = [])
	{
		$this->params = $params;
		$this->headers = $headers;
	}
	
	
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
	public function getCookiesArray(): array { return $this->cookies; }
	public function setCookies(array $cookies): void { $this->cookies = $cookies; }
	public function getCookie(string $cookie, ?string $default = null): ?string { return $this->getCookies()->string($cookie, $default); }
	public function hasCookie(string $cookie): bool { return $this->getCookies()->has($cookie); }
	
	public function getParams(): IInput { return new FromArray($this->getParamsArray()); }
	public function getParam(string $param, ?string $default = null): ?string { return $this->getParams()->string($param, $default); }
	public function hasParam(string $param): bool { return $this->getParams()->has($param); }
	
	public function getQuery(): IInput { return new FromArray($this->getQueryArray()); }
	public function getQueryArray(): array { return $this->params; }
	public function getQueryParam(string $param, ?string $default = null): ?string { return $this->getQuery()->string($param, $default); }
	public function hasQueryParam(string $param): bool { return $this->getQuery()->has($param); }
	
	public function getPost(): IInput { return new FromArray($this->getPostArray()); }
	public function getPostArray(): array { return $this->params; }
	public function getPostParam(string $param, ?string $default = null): ?string { return $this->getPost()->string($param, $default); }
	public function hasPostParam(string $param): bool { return $this->getPost()->has($param); }
	
	
	public function getMethod(): string
	{
		return $this->method;
	}
	
	public function setMethod(string $method): void
	{
		$this->method = $method;
	}
	
	public function isHttps(): bool
	{
		return $this->isHttps;
	}
	
	public function setHttps(bool $isHttps): void
	{
		$this->isHttps = $isHttps;
	}
	
	public function getUserAgent(?string $default = null): ?string
	{
		return $this->userAgent ?: $default;
	}
	
	public function setUserAgent(?string $userAgent): void
	{
		$this->userAgent = $userAgent;
	}
	
	public function getHeadersArray(): array
	{
		return $this->headers;
	}
	
	public function setHeaders(array $headers): void
	{
		$this->headers = $headers;
	}
	
	public function getParamsArray(): array
	{
		return $this->params;
	}
	
	public function setParams(array $params): void
	{
		$this->params = $params;
	}
	
	public function getPort(): ?int
	{
		return $this->port;
	}
	
	public function setPort(?int $port): void
	{
		$this->port = $port;
	}
	
	public function getHost(): string
	{
		return $this->headers['HOST'] ?? '';
	}
	
	public function getIP(?string $default = null): string
	{
		return $this->clientIp ?: '';
	}
	
	public function setIP(?string $ip): void
	{
		$this->clientIp = $ip;
	}
	
	public function getURI(): string
	{
		return $this->uri;
	}
	
	public function setURI(string $uri): void
	{
		$this->uri = $uri;
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
		return $this->body;
	}
	
	public function setBody(string $body): void
	{
		$this->body = $body;
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
	
	
	public static function current(): DummyWebRequest
	{
		if (!self::$current)
			self::$current = new static();
		
		return self::$current;
	}
}