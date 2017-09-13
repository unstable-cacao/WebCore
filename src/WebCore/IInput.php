<?php
namespace WebCore;


use WebCore\Inputs\ArrayInput;


interface IInput
{
	public function has(string $name): bool;
	public function isInt(string $name): bool;
	public function isFloat(string $name): bool;
	public function isEmpty(string $name): bool;
	
	public function int(string $name, ?int $default = null): ?int;
	public function bool(string $name, ?bool $default = null): ?bool;
	public function float(string $name, ?float $default = null): ?float;
	public function regex(string $name, string $regex, ?string $default = null): ?string;
	public function string(string $name, ?string $default = null): ?string;
	public function enum(string $name, $enumValues, ?string $default = null): ?string;
	
	public function require(string $name): string;
	public function requireInt(string $name): int;
	public function requireBool(string $name): bool;
	public function requireFloat(string $name): float;
	public function requireRegex(string $name, string $regex): string;
	public function requireEnum(string $name, $enumValues): ?string;
	
	public function csv(string $name, string $glue = ','): ArrayInput;
	
	public function array(string $name): ArrayInput;
}