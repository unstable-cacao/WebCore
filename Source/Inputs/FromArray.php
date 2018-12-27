<?php
namespace WebCore\Inputs;


use Traitor\TEnum;
use WebCore\Exception\BadRequestException;
use WebCore\Exception\ServerErrorException;
use WebCore\Exception\WebCoreFatalException;
use WebCore\IInput;
use WebCore\Inputs\Utils\BooleanConverter;
use WebCore\Inputs\Utils\InputValidationHelper;


class FromArray implements IInput
{
	private $source;
	
	private $minStrLen;
	private $maxStrLen;
	
	private $min;
	private $max;
	private $minInclusive;
	private $maxInclusive;
	
	
	private function isMatchLength(string $string): bool 
	{
		if (is_null($this->minStrLen) || is_null($this->maxStrLen))
			return true;
		
		$len = strlen($string);
		$result = $len >= $this->minStrLen && $len <= $this->maxStrLen;
		
		$this->minStrLen = null;
		$this->maxStrLen = null;
		
		return $result;
	}
	
	/**
	 * @param int|float $val
	 * @return bool
	 */
	private function isMatchRange($val): bool
	{
		$result = true;
		
		if (!is_null($this->min))
			$result = $result && ($val > $this->min);
		
		if (!is_null($this->max))
			$result = $result && ($val < $this->max);
		
		if (!is_null($this->minInclusive))
			$result = $result && ($val >= $this->minInclusive);
		
		if (!is_null($this->maxInclusive))
			$result = $result && ($val <= $this->maxInclusive);
		
		$this->min = null;
		$this->max = null;
		$this->minInclusive = null;
		$this->maxInclusive = null;
		
		return $result;
	}
	
	
	public function __construct(array $source)
	{
		$this->source = $source;
	}
	
	
	public function withLength(int $length, ?int $max = null): IInput
	{
		if (is_null($max)) 
		{
			$max = $length;
			$length = 0;
		}
		
		if ($max < $length || $max < 0 || $length < 0)
		{
			throw new ServerErrorException("Parameters passed to function are not valid: $length, $max");
		}
		
		$this->minStrLen = $length;
		$this->maxStrLen = $max;
		
		return $this;
	}
	
	public function withExactLength(int $length): IInput
	{
		if ($length < 0) 
		{
			throw new ServerErrorException("Parameters passed to function are not valid: $length");
		}
		
		$this->minStrLen = $length;
		$this->maxStrLen = $length;
		
		return $this;
	}
	
	/**
	 * @param int|float $a
	 * @param int|float $b
	 * @return IInput
	 */
	public function between($a, $b): IInput
	{
		if (!is_numeric($a))
			throw new ServerErrorException("Parameter passed to function must be numeric: $a");
		
		if (!is_numeric($b))
			throw new ServerErrorException("Parameter passed to function must be numeric: $b");
		
		if ($b < $a)
			throw new ServerErrorException("Parameter 'b' is bigger than parameter 'a': $a, $b");
		
		$this->minInclusive = $a;
		$this->maxInclusive = $b;
		
		return $this;
	}
	
	/**
	 * @param int|float $a
	 * @return IInput
	 */
	public function greaterThen($a): IInput
	{
		if (!is_numeric($a))
			throw new ServerErrorException("Parameter passed to function must be numeric: $a");
		
		$this->min = $a;
		
		return $this;
	}
	
	/**
	 * @param int|float $a
	 * @return IInput
	 */
	public function lessThen($a): IInput
	{
		if (!is_numeric($a))
			throw new ServerErrorException("Parameter passed to function must be numeric: $a");
		
		$this->max = $a;
		
		return $this;
	}
	
	/**
	 * @param int|float $a
	 * @return IInput
	 */
	public function greaterOrEqualThen($a): IInput
	{
		if (!is_numeric($a))
			throw new ServerErrorException("Parameter passed to function must be numeric: $a");
		
		$this->minInclusive = $a;
		
		return $this;
	}
	
	/**
	 * @param int|float $a
	 * @return IInput
	 */
	public function lessOrEqualThen($a): IInput
	{
		if (!is_numeric($a))
			throw new ServerErrorException("Parameter passed to function must be numeric: $a");
		
		$this->maxInclusive = $a;
		
		return $this;
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
		return ($this->isInt($name) && $this->isMatchRange((int)$this->source[$name])) ? (int)$this->source[$name] : $default;
	}
	
	public function bool(string $name, ?bool $default = null): ?bool 
	{
		return $this->has($name) && InputValidationHelper::isBool($this->source[$name]) ? 
			BooleanConverter::get($this->source[$name]) : 
			$default;
	}
	
	public function float(string $name, ?float $default = null): ?float 
	{
		return ($this->isFloat($name) && (float)$this->source[$name]) ? (float)$this->source[$name] : $default;
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
		return ($this->has($name) && is_string($this->source[$name]) && $this->isMatchLength($this->source[$name])) ? 
			$this->source[$name] : 
			$default;
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
		    throw new BadRequestException("Required parameter not set");
		
		if (!is_string($this->source[$name]))
			throw new BadRequestException("Required parameter must be string");
		
		if (!$this->isMatchLength($this->source[$name]))
			throw new BadRequestException("Required parameter's length must be between {$this->minStrLen} and {$this->maxStrLen}");
		
		return $this->source[$name];
	}
	
	public function requireInt(string $name): int
	{
        if (!$this->has($name))
			throw new BadRequestException("Required parameter not set");
        
        if (!InputValidationHelper::isInt($this->source[$name]))
			throw new BadRequestException("Required parameter must be int");
        
        if (!$this->isMatchRange((int)$this->source[$name]))
			throw new BadRequestException("Required parameter is not in required range");
        
        return (int)$this->source[$name];
	}
	
	public function requireBool(string $name): bool
	{
        if (!$this->has($name))
			throw new BadRequestException("Required parameter not set");
		
		if (!InputValidationHelper::isBool($this->source[$name]))
			throw new BadRequestException("Required parameter must be bool");
        
        return BooleanConverter::get($this->source[$name]);
	}
	
	public function requireFloat(string $name): float
	{
        if (!$this->has($name))
			throw new BadRequestException("Required parameter not set");
		
		if (!InputValidationHelper::isFloat($this->source[$name]))
			throw new BadRequestException("Required parameter must be bool");
		
		if (!$this->isMatchRange((float)$this->source[$name]))
			throw new BadRequestException("Required parameter is not in required range");
        
        return (float)$this->source[$name];
	}
	
	public function requireRegex(string $name, string $regex): string
	{
        if (!$this->has($name))
			throw new BadRequestException("Required parameter not set");
        
        $isMatched = preg_match($regex, $this->source[$name]);
        
        if ($isMatched === 0)
        {
			throw new BadRequestException("Required parameter must pass regex");
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
			throw new BadRequestException("Required parameter not set");
		
		if (!InputValidationHelper::isEnum($enumValues))
			throw new WebCoreFatalException("Invalid Enum Values passed. Must be array or use the " . TEnum::class);
        
        if (is_array($enumValues))
        {
            if (!in_array($this->source[$name], $enumValues))
				throw new BadRequestException("Required parameter must be enum");
            
            return $this->source[$name];
        }
        else
        {
			/** @var TEnum $enumValues */
			if (!$enumValues::isExists($this->source[$name]))
				throw new BadRequestException("Required parameter must be enum");

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