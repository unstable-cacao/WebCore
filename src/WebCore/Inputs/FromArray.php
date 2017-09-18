<?php
namespace WebCore\Inputs;


use Objection\TEnum;
use WebCore\Exception\WebCoreFatalException;
use WebCore\IInput;
use WebCore\Inputs\Utils\BooleanConverter;
use WebCore\Inputs\Utils\InputValidationHelper;


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
		
		return InputValidationHelper::isInt($value);
	}
	
	public function isFloat(string $name): bool
	{
		if (!$this->has($name))
			return false;
		
		$value = $this->source[$name];
		
		return InputValidationHelper::isFloat($value);
	}
	
	public function isEmpty(string $name): bool
	{
		if (!$this->has($name))
			return false;
		
		return $this->source[$name] == '';
	}
	
	
	public function int(string $name, ?int $default = null): ?int
	{
		return $this->isInt($name) ? (int)$this->source[$name] : $default;
	}
	
	public function bool(string $name, ?bool $default = null): ?bool 
	{
		return $this->has($name) && InputValidationHelper::isBool($this->source[$name]) ? 
			BooleanConverter::get($this->source[$name]) : 
			$default;
	}
	
	public function float(string $name, ?float $default = null): ?float 
	{
		return $this->isFloat($name) ? (float)$this->source[$name] : $default;
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
		return $this->has($name) && is_string($this->source[$name]) ? $this->source[$name] : $default;
	}
	
	public function enum(string $name, $enumValues, ?string $default = null): ?string
	{
		if (!$this->has($name))
			return $default;
		
		if (!InputValidationHelper::isEnum($enumValues))
			throw new WebCoreFatalException("Invalid Enum Values passed. Must be array or use the " . TEnum::class);
		
		if (is_array($enumValues))
		{
			return in_array($this->source[$name], $enumValues) ? $this->source[$name] : $default;
		}
		else
		{
			/** @var TEnum $enumValues */
			return $enumValues::isExists($this->source[$name]) ? $this->source[$name] : $default;
		}
	}
	
	
	public function require(string $name): string
	{
		if (!$this->has($name))
		    throw new WebCoreFatalException("Required parameter not set");
		
		if (!is_string($this->source[$name]))
			throw new WebCoreFatalException("Required parameter must be string");
		
		return $this->source[$name];
	}
	
	public function requireInt(string $name): int
	{
        if (!$this->has($name))
			throw new WebCoreFatalException("Required parameter not set");
        
        if (!InputValidationHelper::isInt($this->source[$name]))
			throw new WebCoreFatalException("Required parameter must be int");
        
        return (int)$this->source[$name];
	}
	
	public function requireBool(string $name): bool
	{
        if (!$this->has($name))
			throw new WebCoreFatalException("Required parameter not set");
		
		if (!InputValidationHelper::isBool($this->source[$name]))
			throw new WebCoreFatalException("Required parameter must be bool");
        
        return BooleanConverter::get($this->source[$name]);
	}
	
	public function requireFloat(string $name): float
	{
        if (!$this->has($name))
			throw new WebCoreFatalException("Required parameter not set");
		
		if (!InputValidationHelper::isFloat($this->source[$name]))
			throw new WebCoreFatalException("Required parameter must be bool");
        
        return (float)$this->source[$name];
	}
	
	public function requireRegex(string $name, string $regex): string
	{
        if (!$this->has($name))
			throw new WebCoreFatalException("Required parameter not set");
        
        $isMatched = preg_match($regex, $this->source[$name]);
        
        if ($isMatched === 0)
        {
			throw new WebCoreFatalException("Required parameter must pass regex");
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
	
	public function requireEnum(string $name, $enumValues): ?string
	{
        if (!$this->has($name))
			throw new WebCoreFatalException("Required parameter not set");
		
		if (!InputValidationHelper::isEnum($enumValues))
			throw new WebCoreFatalException("Invalid Enum Values passed. Must be array or use the " . TEnum::class);
        
        if (is_array($enumValues))
        {
            if (!in_array($this->source[$name], $enumValues))
				throw new WebCoreFatalException("Required parameter must be enum");
            
            return $this->source[$name];
        }
        else
        {
			/** @var TEnum $enumValues */
			if (!$enumValues::isExists($this->source[$name]))
				throw new WebCoreFatalException("Required parameter must be enum");

			return $this->source[$name];
        }
	}
	
	
	public function csv(string $name, string $glue = ','): ArrayInput
	{
		if ($this->has($name) && is_string($this->source[$name])) 
		{
			$array = explode($glue, $this->source[$name]);
			return new ArrayInput($array);
		}
		else
		{
			return new ArrayInput(null);
		}
	}
	
	
	public function array(string $name): ArrayInput
	{
		if ($this->has($name) && is_array($this->source[$name]))
		{
			return new ArrayInput($this->source[$name]);
		}
		else
		{
			return new ArrayInput(null);
		}
	}
}