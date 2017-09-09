<?php
namespace WebCore\Inputs;


use Objection\TEnum;
use PHPUnit\Framework\TestCase;


class FromArrayTest extends TestCase
{
	public function test_has_ItemExists_ReturnTrue()
	{
		$subject = new FromArray(['a' => 1]);
		
		self::assertTrue($subject->has('a'));
	}
	
	public function test_has_ItemNotExists_ReturnFalse()
	{
		$subject = new FromArray([]);
		
		self::assertFalse($subject->has('a'));
	}
	
	public function test_isInt_ItemNotExists_ReturnFalse()
	{
		$subject = new FromArray([]);
		
		self::assertFalse($subject->isInt('a'));
	}
	
	public function test_isInt_ItemIsInt_ReturnTrue()
	{
		$subject = new FromArray(['a' => '1']);
		
		self::assertTrue($subject->isInt('a'));
	}
	
	public function test_isInt_ItemIsNotInt_ReturnFalse()
	{
		$subject = new FromArray(['a' => '1.1']);
		
		self::assertFalse($subject->isInt('a'));
	}
	
	public function test_isFloat_ItemNotExists_ReturnFalse()
	{
		$subject = new FromArray([]);
		
		self::assertFalse($subject->isFloat('a'));
	}
	
	public function test_isFloat_ItemIsFloat_ReturnTrue()
	{
		$subject = new FromArray(['a' => '1.0']);
		
		self::assertTrue($subject->isFloat('a'));
	}
	
	public function test_isFloat_ItemIsNotFloat_ReturnFalse()
	{
		$subject = new FromArray(['a' => '1a']);
		
		self::assertFalse($subject->isFloat('a'));
	}
	
	public function test_isEmpty_NotExists_ReturnFalse()
	{
		$subject = new FromArray([]);
		
		self::assertFalse($subject->isEmpty('a'));
	}
	
	public function test_isEmpty_Empty_ReturnTrue()
	{
		$subject = new FromArray(['a' => '']);
		
		self::assertTrue($subject->isEmpty('a'));
	}
	
	public function test_isEmpty_NotEmpty_ReturnFalse()
	{
		$subject = new FromArray(['a' => '0']);
		
		self::assertFalse($subject->isEmpty('a'));
	}
	
	public function test_int_NotExists_ReturnDefault()
	{
		$subject = new FromArray([]);
		
		self::assertEquals(1, $subject->int('a', 1));
	}
	
	public function test_int_Exists_ReturnItem()
	{
		$subject = new FromArray(['a' => 2]);
		
		self::assertEquals(2, $subject->int('a', 1));
	}
	
	public function test_int_DefaultNotSet_ReturnNull()
	{
		$subject = new FromArray([]);
		
		self::assertNull($subject->int('a'));
	}
	
	public function test_bool_NotExists_ReturnDefault()
	{
		$subject = new FromArray([]);
		
		self::assertTrue($subject->bool('a', true));
	}
	
	public function test_bool_Exists_ReturnItem()
	{
		$subject = new FromArray(['a' => 't']);
		
		self::assertTrue($subject->bool('a', false));
	}
	
	public function test_bool_DefaultNotSet_ReturnNull()
	{
		$subject = new FromArray([]);
		
		self::assertNull($subject->bool('a'));
	}
	
	public function test_float_NotExists_ReturnDefault()
	{
		$subject = new FromArray([]);
		
		self::assertEquals(1.1, $subject->float('a', 1.1));
	}
	
	public function test_float_Exists_ReturnItem()
	{
		$subject = new FromArray(['a' => '3.2']);
		
		self::assertEquals(3.2, $subject->float('a', 1.1));
	}
	
	public function test_float_DefaultNotSet_ReturnNull()
	{
		$subject = new FromArray([]);
		
		self::assertNull($subject->float('a'));
	}
	
	public function test_string_NotExists_ReturnDefault()
	{
		$subject = new FromArray([]);
		
		self::assertEquals('a', $subject->string('a', 'a'));
	}
	
	public function test_string_Exists_ReturnItem()
	{
		$subject = new FromArray(['a' => 'b']);
		
		self::assertEquals('b', $subject->string('a', 'a'));
	}
	
	public function test_string_DefaultNotSet_ReturnNull()
	{
		$subject = new FromArray([]);
		
		self::assertNull($subject->string('a'));
	}
	
	public function test_regex_NotExists_ReturnDefault()
	{
		$subject = new FromArray([]);
		
		self::assertEquals('a', $subject->regex('a', '/./', 'a'));
	}
	
	public function test_regex_ExistsAndValid_ReturnItem()
	{
		$subject = new FromArray(['a' => 'b']);
		
		self::assertEquals('b', $subject->regex('a', '/b/', 'a'));
	}
	
	public function test_regex_ExistsAndNotValid_ReturnDefault()
	{
		$subject = new FromArray(['a' => 'b']);
		
		self::assertEquals('a', $subject->regex('a', '/a/', 'a'));
	}

	/**
	 * @expectedException \WebCore\Exception\WebCoreFatalException
	 */
	public function test_regex_RegexNotValid_ExceptionThrown()
	{
		$subject = new FromArray(['a' => 'b']);
		
		$subject->regex('a', '[', 'a');
	}
	
	public function test_enum_NotExists_ReturnDefault()
	{
		$subject = new FromArray([]);
		
		self::assertEquals('a', $subject->enum('a', [], 'a'));
	}
	
	public function test_enum_ValuesArrayAndExists_ReturnItem()
	{
		$subject = new FromArray(['a' => 'b']);
		
		self::assertEquals('b', $subject->enum('a', ['b'], 'a'));
	}
	
	public function test_enum_ValuesArrayAndNotExists_ReturnDefault()
	{
		$subject = new FromArray(['a' => 'b']);
		
		self::assertEquals('a', $subject->enum('a', ['c'], 'a'));
	}

	/**
	 * @expectedException \WebCore\Exception\WebCoreFatalException
	 */
	public function test_enum_ValuesNotStringOrArray_ExceptionThrown()
	{
		$subject = new FromArray(['a' => 'b']);
		
		$subject->enum('a', 1.1, 'a');
	}
	
	/**
	 * @expectedException \WebCore\Exception\WebCoreFatalException
	 */
	public function test_enum_ValuesNotClass_ExceptionThrown()
	{
		$subject = new FromArray(['a' => 'b']);
		
		$subject->enum('a', 'SomeString', 'a');
	}
	
	/**
	 * @expectedException \WebCore\Exception\WebCoreFatalException
	 */
	public function test_enum_ValuesNotTEnum_ExceptionThrown()
	{
		$subject = new FromArray(['a' => 'b']);
		
		$subject->enum('a', FromArrayTestHelper_A::class, 'a');
	}
	
	public function test_enum_ValuesTEnumAndExists_ReturnItem()
	{
		$subject = new FromArray(['a' => 'b']);
		
		self::assertEquals('b', $subject->enum('a', FromArrayTestHelper_B::class, 'a'));
	}
	
	public function test_enum_ValuesTEnumAndNotExists_ReturnDefault()
	{
		$subject = new FromArray(['a' => 'c']);
		
		self::assertEquals('a', $subject->enum('a', FromArrayTestHelper_B::class, 'a'));
	}
}


class FromArrayTestHelper_A {}

class FromArrayTestHelper_B 
{
	use TEnum;
	
	
	const B = 'b';
}