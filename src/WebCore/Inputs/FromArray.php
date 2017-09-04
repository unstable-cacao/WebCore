<?php
namespace WebCore\Inputs;


use WebCore\IInput;


class FromArray implements IInput
{
	private $source;
	
	
	private function convertToInt($value): int
	{
		return (int)$value;
	}
	
	private function convertToFloat($value): float 
	{
		return (float)$value;
	}
	
	private function convertToBool($value): bool 
	{
		if (is_numeric($value))
		{
			return (bool)((int)$value);
		}
		else if (is_string($value))
		{
			return strtolower($value) == 'true';
		}
		else
		{
			return (bool)$value;
		}
	}
	
	
	public function __construct(array $source)
	{
		$this->source = $source;
	}
	
	
	public function has(string $name): bool
	{
		return key_exists($name, $this->source);
	}
	
	public function isInt(string $name): bool
	{
		if (!$this->has($name))
			return false;
		
		$value = $this->source[$name];
		
		return $value == (string)$this->convertToInt($value);
	}
	
	public function isFloat(string $name): bool
	{
		if (!$this->has($name))
			return false;
		
		$value = $this->source[$name];
		
		return $value == (string)$this->convertToFloat($value);
	}
	
	public function isEmpty(string $name): bool
	{
		return $this->has($name) && !$this->source[$name];
	}
	
	
	public function int(string $name, ?int $default = null): ?int
	{
		if ($this->has($name))
			return $this->convertToInt($this->source[$name]);
		else
			return $default;
	}
	
	public function bool(string $name, ?bool $default = null): ?bool 
	{
		if (!$this->has($name))
			return $default;
		else 
			return $this->convertToBool($this->source[$name]);
	}
	
	public function float(string $name, ?float $default = null): ?float 
	{
		if ($this->has($name))
			return $this->convertToFloat($this->source[$name]);
		else
			return $default;
	}
	
	public function regex(string $name, string $regex, ?string $default = null): ?string
	{
		// TODO: Implement regex() method.
	}
	
	public function string(string $name, ?string $default = null): ?string
	{
		// TODO: Implement string() method.
	}
	
	
	public function enum(string $name, $enumValues, ?string $default = null): ?string
	{
		// TODO: Implement enum() method.
	}
	
	
	/**
	 * @param string $name
	 * @param array $values
	 * @param mixed|null $default
	 * @return mixed|null
	 */
	public function oneOf(string $name, array $values, $default = null)
	{
		// TODO: Implement oneOf() method.
	}
	
	
	public function array(string $name, string $glue = ',', array $default = []): array
	{
		if (!$this->has($name))
			return $default;
		else
			return explode($glue, $this->source[$name]);
	}
	
	public function arrayInt(string $name, string $glue = ',', array $default = []): array
	{
		if (!$this->has($name))
			return $default;
		else
		{
			$values = explode($glue, $this->source[$name]);
			$result = [];
			
			foreach ($values as $value) 
			{
				$result[] = $this->convertToInt($value);
			}
			
			return $result;
		}
	}
	
	public function arrayBool(string $name, string $glue = ',', array $default = []): array
	{
		if (!$this->has($name))
			return $default;
		else
		{
			$values = explode($glue, $this->source[$name]);
			$result = [];
			
			foreach ($values as $value)
			{
				$result[] = $this->convertToBool($value);
			}
			
			return $result;
		}
	}
	
	public function arrayFloat(string $name, string $glue = ',', array $default = []): array
	{
		if (!$this->has($name))
			return $default;
		else
		{
			$values = explode($glue, $this->source[$name]);
			$result = [];
			
			foreach ($values as $value)
			{
				$result[] = $this->convertToFloat($value);
			}
			
			return $result;
		}
	}
	
	public function arrayEnum(string $name, string $glue = ',', $enumValues, array $default = []): array
	{
		// TODO: Implement arrayFloat() method.
	}
	
	
	public function require (string $name): string
	{
		// TODO: Implement require() method.
	}
	
	public function requireInt(string $name): int
	{
		// TODO: Implement requireInt() method.
	}
	
	public function requireBool(string $name): bool
	{
		// TODO: Implement requireBool() method.
	}
	
	public function requireFloat(string $name): float
	{
		// TODO: Implement requireFloat() method.
	}
	
	public function requireRegex(string $name, string $regex): string
	{
		// TODO: Implement requireRegex() method.
	}
	
	
	public function requireArray(string $name, string $glue = ','): array
	{
		// TODO: Implement requireArray() method.
	}
	
	public function requireArrayInt(string $name, string $glue = ','): array
	{
		// TODO: Implement requireArrayInt() method.
	}
	
	public function requireArrayBool(string $name, string $glue = ','): array
	{
		// TODO: Implement requireArrayBool() method.
	}
	
	public function requireArrayFloat(string $name, string $glue = ','): array
	{
		// TODO: Implement requireArrayFloat() method.
	}
}