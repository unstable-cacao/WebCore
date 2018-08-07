<?php
namespace WebCore;


use WebCore\Base\HTTP\IRequestFiles;


interface IWebRequest
{
	public function getMethod(): string;
	public function isMethod(string $method): bool;
	public function isGet(): bool;
	public function isPost(): bool;
	public function isPut(): bool;
	public function isDelete(): bool;
	
	public function isHttp(): bool;
	public function isHttps(): bool;
	public function getPort(): ?int;
	public function getHost(): string;
	public function getIP(): string;
	public function getURI(): string;
	public function getURL(): string;
	
	
	public function getUserAgent(?string $default = null): ?string;
	
	public function getHeaders(): IInput;
	public function getHeadersArray(): array;
	public function getHeader(string $header, ?string $default = null): ?string;
	public function hasHeader(string $header): bool;
	
	public function getCookies(): IInput;
	public function getCookiesArray(): array;
	public function getCookie(string $cookie, ?string $default = null): ?string;
	public function hasCookie(string $cookie): bool;
	
	public function getParams(): IInput;
	public function getParamsArray(): array;
	public function getParam(string $param, ?string $default = null): ?string;
	public function hasParam(string $param): bool;
	
	public function getQuery(): IInput;
	public function getQueryArray(): array;
	public function getQueryParam(string $param, ?string $default = null): ?string;
	public function hasQueryParam(string $param): bool;
	
	public function getPost(): IInput;
	public function getPostArray(): array;
	public function getPostParam(string $param, ?string $default = null): ?string;
	public function hasPostParam(string $param): bool;
	
	public function files(): ?IRequestFiles;
	public function hasFiles(): bool;
	
	public function getBody(): string;
	public function getJson(): array;

	/**
	 * @param $validator
	 * @return mixed
	 */
	public function getValidator($validator);
}