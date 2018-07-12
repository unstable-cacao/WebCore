<?php
namespace WebCore;


interface IWebResponse
{
	public function setHeaders(array $headers): void;
	public function addHeaders(array $headers): void;
	public function setHeader(string $header, string $value): void;
	public function hasHeader(string $header): bool;
	
	public function setCookies(array $cookies): void;
	public function addCookies(array $cookies): void;
	public function setCookieByName(string $cookie, string $value): void;
	public function setCookie(Cookie $cookie): void;
	
	/**
	 * @param string $name
	 * @param null|string $value
	 * @param int|string $expire
	 * @param null|string $path
	 * @param null|string $domain
	 * @param bool $secure
	 * @param bool $serverOnly
	 */
	public function createCookie(
		string $name,
		?string $value = null,
		$expire = 0,
		?string $path = null,
		?string $domain = null,
		bool $secure = false,
		bool $serverOnly = false): void;
	public function hasCookie(string $cookie): bool;
	
	public function setBody(string $body): void;
	public function setBodyCallback(callable $callback): void;
	
	/**
	 * @param array|int|double|bool|string $body
	 */
	public function setJSON($body): void;
}