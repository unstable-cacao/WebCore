<?php
namespace WebCore\Inputs;


use Objection\TEnum;
use WebCore\Exception\WebCoreFatalException;
use WebCore\IInput;
use WebCore\Inputs\Utils\BooleanConverter;


class FromArray implements IInput
{
	private $source;
	
	
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
		
		return $value == (string)((int)$value);
	}
	
	public function isFloat(string $name): bool
	{
		if (!$this->has($name))
			return false;
		
		$value = $this->source[$name];
		
		return $value == (string)((float)$value);
	}
	
	public function isEmpty(string $name): bool
	{
		if (!$this->has($name))
			return false;
		
		return $this->source[$name] == '';
	}
	
	
	public function int(string $name, ?int $default = null): ?int
	{
		return $this->has($name) ? (int)$this->source[$name] : $default;
	}
	
	public function bool(string $name, ?bool $default = null): ?bool 
	{
		return $this->has($name) ? BooleanConverter::get($this->source[$name]) : $default;
	}
	
	public function float(string $name, ?float $default = null): ?float 
	{
		return $this->has($name) ? (float)$this->source[$name] : $default;
	}
	
	public function regex(string $name, string $regex, ?string $default = null): ?string
	{
		if (!$this->has($name))
			return $default;
		
		$isMatched = preg_match($regex, $this->source[$name]);
		
		if ($isMatched === 0)
		{
			return $default;
		}
		else if ($isMatched === 1)
		{
			return $this->source[$name];
		}
		else
		{
			throw new WebCoreFatalException("Invalid regex");
		}
	}
	
	public function string(string $name, ?string $default = null): ?string
	{
		return $this->has($name) ? $this->source[$name] : $default;
	}
	
	public function enum(string $name, $enumValues, ?string $default = null): ?string
	{
		if (!$this->has($name))
			return $default;
		
		if (is_array($enumValues))
		{
			return in_array($this->source[$name], $enumValues) ? $this->source[$name] : $default;
		}
		else
		{
			if (!is_string($enumValues) || 
				!class_exists($enumValues) || 
				!key_exists(TEnum::class, class_uses($enumValues)))
			{
				throw new WebCoreFatalException("Invalid Enum Values passed. Must be array or use the " . TEnum::class);
			}
			else
			{
				/** @var TEnum $enumValues */
				return $enumValues::isExists($this->source[$name]) ? $this->source[$name] : $default;
			}
		}
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
				$result[] = (int)$value;
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
				$result[] = BooleanConverter::get($value);
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
				$result[] = (float)$value;
			}
			
			return $result;
		}
	}
	
	public function arrayEnum(string $name, string $glue = ',', $enumValues, array $default = []): array
	{
		// TODO: Implement arrayFloat() method.
	}
	
	
	public function require(string $name): string
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
	
	public function requireEnum(string $name, $enumValues): ?string
	{
		// TODO: Implement requireEnum() method.
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