<?php
namespace WebCore;


use WebCore\Base\IRequestCookies;
use WebCore\Base\IRequestFiles;
use WebCore\Base\IRequestHeaders;


interface IRequest
{
	public function getHeaders(): IRequestHeaders;
	public function getHeadersArray(): array;
	public function getHeader(string $header, ?string $default = null): ?string;
	public function hasHeader(string $header): bool;
	
	public function getCookies(): IRequestCookies;
	public function getCookiesArray(): array;
	public function getCookie(string $cookie, ?string $default = null): ?string;
	public function hasCookie(string $cookie): bool;
	
	public function getFiles(): IRequestFiles;
	public function getFilesArray(): array;
	public function getFile(string $file);
	public function hasFile(string $file): bool;
	
	public function getMethod(): string;
	public function isMethod(string $method): bool;
	public function isGet(): bool;
	public function isPost(): bool;
	public function isPut(): bool;
	public function isDelete(): bool;
	
	public function isHttps(): bool;
	public function getDomain(): string;
	public function getHost(): string;
	public function getUri(): string;
	public function getUrl(): string;
	
	public function getParams(): array;
	public function getParam(string $param, $default = null);
	public function hasParam(string $param): bool;
	
	public function getQueryParams(): array;
	public function getQueryParam(string $param, $default = null);
	public function hasQueryParam(string $param): bool;
	
	public function getPostParams(): array;
	public function getPostParam(string $param, $default = null);
	public function hasPostParam(string $param): bool;
	
	public function getBody(): array;
	public function getBodyRaw(): string;
	public function getBodyParam(string $param, $default = null);
	public function hasBodyParam(string $param): bool;
}