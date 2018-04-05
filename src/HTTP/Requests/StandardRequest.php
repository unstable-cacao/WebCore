<?php
namespace WebCore\HTTP\Requests;


use WebCore\Method;
use WebCore\IRequest;
use WebCore\Base\HTTP\IRequestFiles;
use WebCore\HTTP\Utilities\HeadersLoader;
use WebCore\HTTP\Utilities\RequestParams;
use WebCore\HTTP\Utilities\IsHTTPSValidator;
use WebCore\Exception\WebCoreFatalException;


class StandardRequest implements IRequest
{
	private static $current = null;
	
	
	private $headers	= null;
	private $isHttps	= null;
	private $method		= null;
	private $params		= null;
	private $body		= null;
	

	public function isMethod(string $method): bool { return $this->getMethod() == $method; }
	public function isGet(): bool { return $this->getMethod() == Method::GET; }
	public function isPost(): bool { return $this->getMethod() == Method::POST; }
	public function isPut(): bool { return $this->getMethod() == Method::PUT; }
	public function isDelete(): bool { return $this->getMethod() == Method::DELETE; }
	
	public function isHttp(): bool { return !$this->$this->isHttps(); }
	
	public function getHeader(string $header, ?string $default = null): ?string { return $this->getHeaders()[$header] ?? $default; }
	public function hasHeader(string $header): bool { return isset($this->getHeaders()[$header]); }
	
	public function getCookies(): array { return $_COOKIE;	}
	public function getCookie(string $cookie, ?string $default = null): ?string { return $_COOKIE[$cookie] ?? $default;	}
	public function hasCookie(string $cookie): bool { return isset($_COOKIE[$cookie]); }
	
	public function getParam(string $param, ?string $default = null): ?string { return $this->getParams()[$param] ?? $default; }
	public function hasParam(string $param): bool { return isset($this->getParams()[$param]); }
	
	public function getQueryParams(): array { return $_GET; }
	public function getQueryParam(string $param, ?string $default = null): ?string { return $_GET[$param] ?? $default; }
	public function hasQueryParam(string $param): bool { return isset($_GET[$param]); } 

	public function getPostParams(): array { return $_GET; }
	public function getPostParam(string $param, ?string $default = null): ?string { return $_GET[$param] ?? $default; }
	public function hasPostParam(string $param): bool { return isset($_GET[$param]); }
	
	
	public function getMethod(): string
	{
		if (is_null($this->method))
			$this->method = $_SERVER['REQUEST_METHOD'];
		
		return $this->method;
	}
	
	public function isHttps(): bool
	{
		if (is_null($this->isHttps))
			$this->isHttps = IsHTTPSValidator::isHttps();
		
		return $this->isHttps;
	}

	public function getHeaders(): array
	{
		if (is_null($this->headers))
			$this->headers = HeadersLoader::getAllHeaders();
		
		return $this->headers;
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

	public function getURI(): string
	{
		return $_SERVER['REQUEST_URI'] ?? '';
	}

	public function getURL(): string
	{
		$protocol = $this->isHttp() ? 'http' : 'https';
		return "{$protocol}://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
	}

	public function getParams(): array
	{
		if ($this->params)
			$this->params = RequestParams::get();
		
		return $this->params;
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
	
	
	public static function current(): StandardRequest
	{
		if (!self::$current)
			self::$current = new static();
		
		return self::$current;
	}
}