<?php
namespace WebCore;


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
	
	public function csv(string $name, string $glue = ',', array $default = []): array;
	public function csvInt(string $name, string $glue = ',', array $default = []): array;
	public function csvBool(string $name, string $glue = ',', array $default = []): array;
	public function csvFloat(string $name, string $glue = ',', array $default = []): array;
	public function csvEnum(string $name, string $glue = ',', $enumValues, array $default = []): array;
	
	public function array(string $name, array $default = []): array;
	public function arrayInt(string $name, array $default = []): array;
	public function arrayBool(string $name, array $default = []): array;
	public function arrayFloat(string $name, array $default = []): array;
	public function arrayEnum(string $name, $enumValues, array $default = []): array;
	
	public function require(string $name): string;
	public function requireInt(string $name): int;
	public function requireBool(string $name): bool;
	public function requireFloat(string $name): float;
	public function requireRegex(string $name, string $regex): string;
	public function requireEnum(string $name, $enumValues): ?string;
	
	public function requireCsv(string $name, string $glue = ','): array;
	public function requireCsvInt(string $name, string $glue = ','): array;
	public function requireCsvBool(string $name, string $glue = ','): array;
	public function requireCsvFloat(string $name, string $glue = ','): array;
	
	public function requireArray(string $name): array;
	public function requireArrayInt(string $name): array;
	public function requireArrayBool(string $name): array;
	public function requireArrayFloat(string $name): array;
}