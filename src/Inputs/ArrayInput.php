<?php
namespace WebCore\Inputs;


use Objection\TEnum;
use WebCore\Exception\BadRequestException;
use WebCore\Exception\WebCoreFatalException;
use WebCore\Inputs\Utils\BooleanConverter;
use WebCore\Inputs\Utils\InputValidationHelper;


class ArrayInput
{
	/** @var array|null */
	private $source;
	
	
	private function parseSource(callable $callable, ?array $default = null): ?array 
	{
		$result = [];
		
		foreach ($this->source as $item)
		{
			$return = $callable($item);
			
			if (is_null($return))
				return $default;
			
			$result[] = $return;
		}
		
		return $result;
	}
	
	private function filterSource(callable $callable): array
	{
		$result = [];
		
		foreach ($this->source as $item)
		{
			$return = $callable($item);
			
			if (is_null($return))
				continue;
			
			$result[] = $return;
		}
		
		return $result;
	}
	
	
	/**
	 * @param array|null $source
	 */
	public function __construct($source)
	{
		if (!is_array($source) && !is_null($source))
			throw new WebCoreFatalException("Source expected to be array or null");
		
		$this->source = $source;
	}
	
	
	public function get(?array $default = null): ?array 
	{
		return !is_null($this->source) ? $this->source : $default;
	}
	
	public function getInt(?array $default = null): ?array 
	{
		if (is_null($this->source))
			return $default;
		
		return $this->parseSource(function($item) {
			return InputValidationHelper::isInt($item) ? (int)$item : null;
		}, $default);
	}
	
	public function getFloat(?array $default = null): ?array 
	{
		if (is_null($this->source))
			return $default;
		
		return $this->parseSource(function($item) {
			return InputValidationHelper::isFloat($item) ? (float)$item : null;
		}, $default);
	}
	
	public function getBool(?array $default = null): ?array
	{
		if (is_null($this->source))
			return $default;
		
		return $this->parseSource(function($item) {
			return InputValidationHelper::isBool($item) ? BooleanConverter::get($item) : null;
		}, $default);
	}
	
	public function getEnum($enumValues, ?array $default = null): ?array
	{
		if (is_null($this->source))
			return $default;
		
		if (!InputValidationHelper::isEnum($enumValues))
			throw new WebCoreFatalException("Invalid Enum Values passed. Must be array or use the " . TEnum::class);
		
		if (is_array($enumValues))
		{
			return $this->parseSource(function($item) use ($enumValues) {
				return in_array($item, $enumValues) ? $item : null;
			}, $default);
		}
		else
		{
			return $this->parseSource(function($item) use ($enumValues) {
				/** @var TEnum $enumValues */
				return $enumValues::isExists($item) ? $item : null;
			}, $default);
		}
	}
	
	
	public function filterInt(?array $default = null): ?array
	{
		if (is_null($this->source))
			return $default;
		
		return $this->filterSource(function($item) {
			return InputValidationHelper::isInt($item) ? (int)$item : null;
		});
	}
	
	public function filterFloat(?array $default = null): ?array
	{
		if (is_null($this->source))
			return $default;
		
		return $this->filterSource(function($item) {
			return InputValidationHelper::isFloat($item) ? (float)$item : null;
		});
	}
	
	public function filterBool(?array $default = null): ?array
	{
		if (is_null($this->source))
			return $default;
		
		return $this->filterSource(function($item) {
			return InputValidationHelper::isBool($item) ? BooleanConverter::get($item) : null;
		});
	}
	
	public function filterEnum($enumValues, ?array $default = null): ?array
	{
		if (is_null($this->source))
			return $default;
		
		if (!InputValidationHelper::isEnum($enumValues))
			throw new WebCoreFatalException("Invalid Enum Values passed. Must be array or use the " . TEnum::class);
		
		if (is_array($enumValues))
		{
			return $this->filterSource(function($item) use ($enumValues) {
				return in_array($item, $enumValues) ? $item : null;
			});
		}
		else
		{
			return $this->filterSource(function($item) use ($enumValues) {
				/** @var TEnum $enumValues */
				return $enumValues::isExists($item) ? $item : null;
			});
		}
	}
	
	
	public function require(): array
	{
		if (is_null($this->source))
			throw new BadRequestException("Required parameter not set");
		
		return $this->source;
	}
	
	public function requireInt(): array
	{
		if (is_null($this->source))
			throw new BadRequestException("Required parameter not set");
		
		return $this->parseSource(function($item) {
			if (!InputValidationHelper::isInt($item))
				throw new BadRequestException("Required to be int");
			
			return (int)$item;
		});
	}
	
	public function requireFloat(): array
	{
		if (is_null($this->source))
			throw new BadRequestException("Required parameter not set");
		
		return $this->parseSource(function($item) {
			if (!InputValidationHelper::isFloat($item))
				throw new BadRequestException("Required to be float");
			
			return (float)$item;
		});
	}
	
	public function requireBool(): array
	{
		if (is_null($this->source))
			throw new BadRequestException("Required parameter not set");
		
		return $this->parseSource(function($item) {
			if (!InputValidationHelper::isBool($item))
				throw new BadRequestException("Required to be bool");
			
			return BooleanConverter::get($item);
		});
	}
	
	public function requireEnum($enumValues): array
	{
		if (is_null($this->source))
			throw new BadRequestException("Required parameter not set");
		
		if (!InputValidationHelper::isEnum($enumValues))
			throw new WebCoreFatalException("Invalid Enum Values passed. Must be array or use the " . TEnum::class);
		
		if (is_array($enumValues))
		{
			return $this->parseSource(function($item) use ($enumValues) {
				if (!in_array($item, $enumValues))
					throw new BadRequestException("Required to be Enum");
				
				return $item;
			});
		}
		else
		{
			return $this->parseSource(function($item) use ($enumValues) {
				/** @var TEnum $enumValues */
				if (!$enumValues::isExists($item))
					throw new BadRequestException("Required to be Enum");
				
				return $item;
			});
		}
	}
}