<?php
namespace WebCore\HTTP\Utilities;


use PHPUnit\Framework\TestCase;


class IsHTTPSValidatorTest extends TestCase
{
	protected function setUp()
	{
		$_SERVER = [];
		resetStaticDataMember(IsHTTPSValidator::class, 'isHttps');
	}
	
	
	public function test_isHttps_PrivetMemberNotNull_ReturnMember()
	{
		$_SERVER['HTTPS'] = 'on';
		IsHTTPSValidator::isHttps();
		
		$_SERVER['HTTPS'] = 'off';
		
		self::assertTrue(IsHTTPSValidator::isHttps());
	}
	
	public function test_isHttps_HTTPSSetNotOff_ReturnTrue()
	{
		$_SERVER['HTTPS'] = 'on';
		
		self::assertTrue(IsHTTPSValidator::isHttps());
	}
	
	public function test_isHttps_HTTPSSetOff_ReturnFalse()
	{
		$_SERVER['HTTPS'] = 'off';
		
		self::assertFalse(IsHTTPSValidator::isHttps());
	}
	
	public function test_isHttps_DefaultBehavior_ReturnFalse()
	{
		self::assertFalse(IsHTTPSValidator::isHttps());
	}
	
	
	public static function tearDownAfterClass()
	{
		$_SERVER = [];
	}
}