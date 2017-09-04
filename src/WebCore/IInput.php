<?php
namespace WebCore;


/**
 * Bool:
 * 	false:
 * 		<empty value>, 0, false, f, off
 *  true:
 * 		Everything else
 */
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

	/**
	 * @param string $name
	 * @param array $values
	 * @param mixed|null $default
	 * @return mixed|null
	 */
	public function oneOf(string $name, array $values, $default = null);
	
	public function array(string $name, string $glue = ',', array $default = []): array;
	public function arrayInt(string $name, string $glue = ',', array $default = []): array;
	public function arrayBool(string $name, string $glue = ',', array $default = []): array;
	public function arrayFloat(string $name, string $glue = ',', array $default = []): array;
	public function arrayEnum(string $name, string $glue = ',', $enumValues, array $default = []): array;
	
	public function require(string $name): string;
	public function requireInt(string $name): int;
	public function requireBool(string $name): bool;
	public function requireFloat(string $name): float;
	public function requireRegex(string $name, string $regex): string;
	
	public function requireArray(string $name, string $glue = ','): array;
	public function requireArrayInt(string $name, string $glue = ','): array;
	public function requireArrayBool(string $name, string $glue = ','): array;
	public function requireArrayFloat(string $name, string $glue = ','): array;
}