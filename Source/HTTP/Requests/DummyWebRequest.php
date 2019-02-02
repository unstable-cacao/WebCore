<?php
namespace WebCore\HTTP\Requests;


use WebCore\Method;
use WebCore\IInput;
use WebCore\IWebRequest;
use WebCore\Base\HTTP\IRequestFiles;
use WebCore\Inputs\FromArray;
use WebCore\Exception\WebCoreFatalException;


class DummyWebRequest implements IWebRequest
{
	private static $current = null;
	
	
	private $headers		= [];
	private $isHttps		= false;
	private $method			= Method::GET;
	private $params			= [];
	private $requestParams 	= [];
	private $routeParams	= [];
	private $body			= '';
	private $port			= null;
	private $userAgent		= null;
	private $clientIp		= null;
	private $uri			= '';
	private $cookies		= [];
	
	
	public function __construct(array $params = [], array $headers = [])
	{
		$this->params = $params;
		$this->headers = $headers;
	}
	
	
	public function isMethod(string $method): bool 
	{ 
		return $this->getMethod() == $method; 
	}
	
	public function isGet(): bool 
	{ 
		return $this->getMethod() == Method::GET; 
	}
	
	public function isPost(): bool 
	{ 
		return $this->getMethod() == Method::POST; 
	}
	
	public function isPut(): bool 
	{ 
		return $this->getMethod() == Method::PUT; 
	}
	
	public function isDelete(): bool 
	{ 
		return $this->getMethod() == Method::DELETE; 
	}
	
	public function isHttp(): bool 
	{ 
		return !$this->isHttps(); 
	}
	
	
	public function getHeaders(bool $caseSensitive = false): IInput 
	{ 
		return new FromArray($this->getHeadersArray($caseSensitive)); 
	}
	
	public function getHeader(string $header, ?string $default = null, bool $caseSensitive = false): ?string 
	{ 
		if (!$caseSensitive)
			$header = strtolower($header);
		
		$headers = $this->getHeadersArray($caseSensitive);
		return $headers[$header] ?? $default; 
	}
	
	public function hasHeader(string $header, bool $caseSensitive = false): bool 
	{
		if (!$caseSensitive)
			$header = strtolower($header);
		
		return key_exists($header, $this->getHeadersArray($caseSensitive));
	}
	
	public function getCookies(): IInput 
	{ 
		return new FromArray($this->getCookiesArray()); 
	}
	
	public function getCookiesArray(): array 
	{ 
		return $this->cookies; 
	}
	
	public function setCookies(array $cookies): void 
	{ 
		$this->cookies = $cookies; 
	}
	
	public function getCookie(string $cookie, ?string $default = null): ?string 
	{ 
		return $this->getCookies()->string($cookie, $default); 
	}
	
	public function hasCookie(string $cookie): bool 
	{ 
		return $this->getCookies()->has($cookie); 
	}
	
	public function getParams(): IInput 
	{ 
		return new FromArray($this->getParamsArray()); 
	}
	
	public function getParam(string $param, ?string $default = null): ?string 
	{ 
		return $this->getParams()->string($param, $default); 
	}
	
	public function hasParam(string $param): bool 
	{ 
		return $this->getParams()->has($param); 
	}
	
	public function getQuery(): IInput 
	{ 
		return new FromArray($this->getQueryArray()); 
	}
	
	public function getQueryArray(): array 
	{ 
		return $this->params; 
	}
	
	public function getQueryParam(string $param, ?string $default = null): ?string 
	{ 
		return $this->getQuery()->string($param, $default); 
	}
	
	public function hasQueryParam(string $param): bool 
	{ 
		return $this->getQuery()->has($param); 
	}
	
	public function getPost(): IInput 
	{ 
		return new FromArray($this->getPostArray()); 
	}
	
	public function getPostArray(): array 
	{ 
		return $this->params; 
	}
	
	public function getPostParam(string $param, ?string $default = null): ?string 
	{ 
		return $this->getPost()->string($param, $default); 
	}
	
	public function hasPostParam(string $param): bool 
	{ 
		return $this->getPost()->has($param); 
	}
	
	
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
	
	public function getHeadersArray(bool $caseSensitive = false): array
	{
		if ($caseSensitive)
		{
			return $this->headers;
		} 
		else 
		{
			$result = [];
			
			foreach ($this->headers as $header => $value)
			{
				$result[strtolower($header)] = $value;
			}
			
			return $result;
		}
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
	
	public function getRequestParams(): IInput
	{
		return new FromArray($this->getRequestParamsArray());
	}
	
	public function setRequestParams(array $params): void
	{
		$this->requestParams = $params;
	}
	
	public function getRequestParamsArray(): array
	{
		if (is_null($this->requestParams))
		{
			$this->requestParams = array_merge($this->getPostArray(), $this->getQueryArray(), $this->getRouteParamsArray());
		}
		
		return $this->requestParams;
	}
	
	public function getRequestParam(string $param, ?string $default = null): ?string
	{
		return $this->getRequestParams()->string($param, $default);
	}
	
	public function hasRequestParam(string $param): bool
	{
		return $this->getRequestParams()->has($param);
	}
	
	public function setRouteParams(array $params): void
	{
		$this->requestParams = $params;
	}
	
	public function getRouteParams(): IInput
	{
		return new FromArray($this->getRouteParamsArray());
	}
	
	public function getRouteParamsArray(): array
	{
		return $this->routeParams;
	}
	
	public function getRouteParam(string $param, ?string $default = null): ?string
	{
		return $this->getRouteParams()->string($param, $default);
	}
	
	public function hasRouteParam(string $param): bool
	{
		return $this->getRouteParams()->has($param);
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
	
	public function getPath(): string
	{
		return explode('?', explode('#', $this->uri, 2)[0], 2)[0];
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
	
	
	public static function current(): DummyWebRequest
	{
		if (!self::$current)
			self::$current = new static();
		
		return self::$current;
	}
}