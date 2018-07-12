<?php
namespace WebCore;


interface IWebResponse
{
	public function getHeaders(): IInput;
	public function getHeadersArray(): array;
	public function setHeaders(array $headers): void;
	
	/**
	 * @param string $header
	 * @param string|int $value
	 */
	public function setHeader(string $header, $value): void;
	public function hasHeader(string $header): bool;
	
	public function getCookies(): IInput;
	public function getCookiesArray(): array;
	public function setCookies(array $cookies): void;
	
	/**
	 * @param string $cookie
	 * @param string|int $value
	 */
	public function setCookieByName(string $cookie, $value): void;
	public function setCookie(Cookie $cookie): void;
	public function hasCookie(string $cookie): bool;
	
	public function getBody(): string;
	public function setBody(string $body): void;
	public function setJSON(array $params): void;
}