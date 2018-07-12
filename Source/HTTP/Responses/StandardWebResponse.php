<?php
namespace WebCore\HTTP\Responses;


use WebCore\Cookie;
use WebCore\IInput;
use WebCore\Inputs\FromArray;
use WebCore\IWebResponse;


class StandardWebResponse implements IWebResponse
{
	private $headers 	= [];
	
	/** @var Cookie[] */
	private $cookies 	= [];
	
	private $body 		= '';
	
	
	public function getHeaders(): IInput
	{
		return new FromArray($this->headers);
	}
	
	public function getHeadersArray(): array
	{
		return $this->headers;
	}
	
	public function setHeaders(array $headers): void
	{
		$this->headers = $headers;
	}
	
	/**
	 * @param string $header
	 * @param string|int $value
	 */
	public function setHeader(string $header, $value): void
	{
		$this->headers[$header] = $value;
	}
	
	public function hasHeader(string $header): bool
	{
		return isset($this->headers[$header]);
	}
	
	public function getCookies(): IInput
	{
		return new FromArray($this->cookies);
	}
	
	public function getCookiesArray(): array
	{
		return $this->cookies;
	}
	
	public function setCookies(array $cookies): void
	{
		$this->cookies = $cookies;
	}
	
	/**
	 * @param string $cookie
	 * @param string|int $value
	 */
	public function setCookieByName(string $cookie, $value): void
	{
		$this->cookies[$cookie] = Cookie::create($cookie, (string)$value);
	}
	
	public function setCookie(Cookie $cookie): void
	{
		$this->cookies[$cookie->Name] = $cookie;
	}
	
	public function hasCookie(string $cookie): bool
	{
		return isset($this->cookies[$cookie]);
	}
	
	public function getBody(): string
	{
		return $this->body;
	}
	
	public function setBody(string $body): void
	{
		$this->body = $body;
	}
	
	public function setJSON(array $params): void
	{
		$this->body = jsonencode($params);
	}
}