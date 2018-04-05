<?php
namespace WebCore\Base\HTTP;


interface IRequestFile
{
	public function name(): ?string;
	public function path(): ?string;
	public function type(): ?string;
	public function size(): ?int;
	public function content(): ?string;
	public function errorCode(): int;
}