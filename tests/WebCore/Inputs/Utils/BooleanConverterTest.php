<?php
namespace WebCore\Inputs\Utils;


use PHPUnit\Framework\TestCase;


class BooleanConverterTest extends TestCase
{
	public function test_get_TestFalseValues_ReturnFalse()
	{
		self::assertFalse(BooleanConverter::get(''));
		self::assertFalse(BooleanConverter::get('0'));
		self::assertFalse(BooleanConverter::get('false'));
		self::assertFalse(BooleanConverter::get('f'));
		self::assertFalse(BooleanConverter::get('off'));
	}
	
	public function test_get_TestTrueValues_ReturnTrue()
	{
		self::assertTrue(BooleanConverter::get('SomeText'));
		self::assertTrue(BooleanConverter::get('1'));
		self::assertTrue(BooleanConverter::get('true'));
		self::assertTrue(BooleanConverter::get('t'));
		self::assertTrue(BooleanConverter::get('on'));
	}
}