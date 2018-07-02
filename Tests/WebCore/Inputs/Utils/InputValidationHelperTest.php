<?php
namespace WebCore\Inputs\Utils;


use PHPUnit\Framework\TestCase;
use Traitor\TEnum;


class InputValidationHelperTest extends TestCase
{
	public function test_isInt_Int_ReturnTrue()
	{
		self::assertTrue(InputValidationHelper::isInt(5));
	}
	
	public function test_isInt_NumericString_ReturnTrue()
	{
		self::assertTrue(InputValidationHelper::isInt('5'));
	}
	
	public function test_isInt_NonNumericString_ReturnFalse()
	{
		self::assertFalse(InputValidationHelper::isInt('fun5'));
	}
	
	public function test_isInt_Array_ReturnFalse()
	{
		self::assertFalse(InputValidationHelper::isInt([]));
	}
	
	public function test_isFloat_Float_ReturnTrue()
	{
		self::assertTrue(InputValidationHelper::isFloat(5.5));
	}
	
	public function test_isFloat_FloatString_ReturnTrue()
	{
		self::assertTrue(InputValidationHelper::isFloat('5.5'));
	}
	
	public function test_isFloat_NonFloatString_ReturnFalse()
	{
		self::assertFalse(InputValidationHelper::isFloat('fun5.5'));
	}
	
	public function test_isFloat_Array_ReturnFalse()
	{
		self::assertFalse(InputValidationHelper::isFloat([]));
	}
	
	public function test_isBool_String_ReturnTrue()
	{
		self::assertTrue(InputValidationHelper::isBool('someString'));
	}
	
	public function test_isBool_Array_ReturnFalse()
	{
		self::assertFalse(InputValidationHelper::isBool([]));
	}
	
	public function test_isEnum_Array_ReturnTrue()
	{
		self::assertTrue(InputValidationHelper::isEnum([]));
	}
	
	public function test_isEnum_ClassNotTEnum_ReturnFalse()
	{
		self::assertFalse(InputValidationHelper::isEnum(InputValidationHelperTestHelper_A::class));
	}
	
	public function test_isEnum_NotAClass_ReturnFalse()
	{
		self::assertFalse(InputValidationHelper::isEnum('ARandomString'));
	}
	
	public function test_isEnum_NotStringOrArray_ReturnFalse()
	{
		self::assertFalse(InputValidationHelper::isEnum(true));
	}
	
	public function test_isEnum_TEnum_ReturnTrue()
	{
		self::assertTrue(InputValidationHelper::isEnum(InputValidationHelperTestHelper_B::class));
	}
}


class InputValidationHelperTestHelper_A {}

class InputValidationHelperTestHelper_B
{
	use TEnum;
}