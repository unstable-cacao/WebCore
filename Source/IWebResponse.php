<?php
namespace WebCore;


interface IWebResponse
{
	public function setCode(int $code): void;
	public function getCode(): int;
	
	public function setHeaders(array $headers): void;
	public function addHeaders(array $headers): void;
	public function setHeader(string $header, ?string $value = null): void;
	public function hasHeader(string $header): bool;
	public function getHeaders(): array;
	
	public function setCookies(array $cookies): void;
	public function addCookies(array $cookies): void;
	public function setCookieByName(string $cookie, string $value): void;
	public function setCookie(Cookie $cookie): void;
	public function getCookies(): array;
	
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
	
	/**
	 * @param string $name
	 * @param null|string $path
	 * @param null|string $domain
	 * @param bool $secure
	 * @param bool $serverOnly
	 */
	public function deleteCookie(
		string $name,
		?string $path = null,
		?string $domain = null,
		bool $secure = false,
		bool $serverOnly = false): void;
	
	public function setBody(string $body): void;
	public function setBodyCallback(callable $callback): void;
	public function hasBody(): bool;
	public function getBody(): ?string;
	
	/**
	 * @param array|int|double|bool|string $body
	 */
	public function setJSON($body): void;
	
	public function apply(): void;
}