<?php
namespace WebCore\Inputs;


use Objection\TEnum;
use WebCore\Exception\BadRequestException;
use WebCore\Inputs\Utils\BooleanConverter;
use WebCore\Inputs\Utils\InputValidationHelper;


class ArrayInput
{
	/** @var array|null */
	private $source;
	
	
	/**
	 * @param array|null $source
	 */
	public function __construct($source)
	{
		if (is_array($source) || is_null($source))
		{
			$this->source = $source;
		}
		else
		{
			throw new \Exception("Source expected to be array or null");
		}
	}
	
	
	public function get(?array $default = null): ?array 
	{
		return !is_null($this->source) ? $this->source : $default;
	}
	
	public function getInt(?array $default = null): ?array 
	{
		if (is_null($this->source))
			return $default;
		
		$result = [];
		
		foreach ($this->source as $item) 
		{
			if (!InputValidationHelper::isInt($item))
				return $default;
			
			$result[] = (int)$item;
		}
		
		return $result;
	}
	
	public function getFloat(?array $default = null): ?array 
	{
		if (is_null($this->source))
			return $default;
		
		$result = [];
		
		foreach ($this->source as $item)
		{
			if (!InputValidationHelper::isFloat($item))
				return $default;
			
			$result[] = (float)$item;
		}
		
		return $result;
	}
	
	public function getBool(?array $default = null): ?array
	{
		if (is_null($this->source))
			return $default;
		
		$result = [];
		
		foreach ($this->source as $item)
		{
			if (!InputValidationHelper::isBool($item))
				return $default;
			
			$result[] = BooleanConverter::get($item);
		}
		
		return $result;
	}
	
	public function getEnum($enumValues, ?array $default = null): ?array
	{
		if (is_null($this->source))
			return $default;
		
		if (!InputValidationHelper::isEnum($enumValues))
			throw new \Exception("Not valid Enum Values");
		
		$result = [];
		
		if (is_array($enumValues))
		{
			foreach ($this->source as $item)
			{
				if (!in_array($item, $enumValues))
					return $default;
				
				$result[] = $item;
			}
		}
		else
		{
			foreach ($this->source as $item)
			{
				/** @var TEnum $enumValues */
				if (!$enumValues::isExists($item))
					return $default;
				
				$result[] = $item;
			}
		}
		
		return $result;
	}
	
	
	public function filterInt(?array $default = null): ?array
	{
		if (is_null($this->source))
			return $default;
		
		$result = [];
		
		foreach ($this->source as $item)
		{
			if (!InputValidationHelper::isInt($item))
				continue;
			
			$result[] = (int)$item;
		}
		
		return $result;
	}
	
	public function filterFloat(?array $default = null): ?array
	{
		if (is_null($this->source))
			return $default;
		
		$result = [];
		
		foreach ($this->source as $item)
		{
			if (!InputValidationHelper::isFloat($item))
				continue;
			
			$result[] = (float)$item;
		}
		
		return $result;
	}
	
	public function filterBool(?array $default = null): ?array
	{
		if (is_null($this->source))
			return $default;
		
		$result = [];
		
		foreach ($this->source as $item)
		{
			if (!InputValidationHelper::isBool($item))
				continue;
			
			$result[] = BooleanConverter::get($item);
		}
		
		return $result;
	}
	
	public function filterEnum($enumValues, ?array $default = null): ?array
	{
		if (is_null($this->source))
			return $default;
		
		if (!InputValidationHelper::isEnum($enumValues))
			throw new \Exception("Not valid Enum Values");
		
		$result = [];
		
		if (is_array($enumValues))
		{
			foreach ($this->source as $item)
			{
				if (!in_array($item, $enumValues))
					continue;
				
				$result[] = $item;
			}
		}
		else
		{
			foreach ($this->source as $item)
			{
				/** @var TEnum $enumValues */
				if (!$enumValues::isExists($item))
					continue;
				
				$result[] = $item;
			}
		}
		
		return $result;
	}
	
	
	public function require(): array
	{
		if (is_null($this->source))
			throw new \Exception("Required parameter not set");
		
		return $this->source;
	}
	
	public function requireInt(): array
	{
		if (!$this->source)
			throw new \Exception("Required parameter not set");
		
		$result = [];
		
		foreach ($this->source as $item)
		{
			if (!InputValidationHelper::isInt($item))
				throw new \Exception("Required to be int");
			
			$result[] = (int)$item;
		}
		
		return $result;
	}
	
	public function requireFloat(): array
	{
		if (!$this->source)
			throw new \Exception("Required parameter not set");
		
		$result = [];
		
		foreach ($this->source as $item)
		{
			if (!InputValidationHelper::isFloat($item))
				throw new \Exception("Required to be float");
			
			$result[] = (float)$item;
		}
		
		return $result;
	}
	
	public function requireBool(): array
	{
		if (!$this->source)
			throw new \Exception("Required parameter not set");
		
		$result = [];
		
		foreach ($this->source as $item)
		{
			if (!InputValidationHelper::isBool($item))
				throw new \Exception("Required to be bool");
			
			$result[] = BooleanConverter::get($item);
		}
		
		return $result;
	}
	
	public function requireEnum($enumValues): array
	{
		if (!$this->source)
			throw new \Exception("Required parameter not set");
		
		if (!InputValidationHelper::isEnum($enumValues))
			throw new BadRequestException();
		
		$result = [];
		
		if (is_array($enumValues))
		{
			foreach ($this->source as $item)
			{
				if (!in_array($item, $enumValues))
					throw new \Exception("Required to be Enum");
				
				$result[] = $item;
			}
		}
		else
		{
			foreach ($this->source as $item)
			{
				/** @var TEnum $enumValues */
				if (!$enumValues::isExists($item))
					throw new \Exception("Required to be Enum");
				
				$result[] = $item;
			}
		}
		
		return $result;
	}
}