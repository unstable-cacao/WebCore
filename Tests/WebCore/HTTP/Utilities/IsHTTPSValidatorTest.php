<?php
namespace WebCore\HTTP\Utilities;


use PHPUnit\Framework\TestCase;


class IsHTTPSValidatorTest extends TestCase
{
	private static array $server = [];
	
	
	protected function setUp(): void
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
	
	
	public static function setUpBeforeClass(): void
	{
		self::$server = $_SERVER;
	}
	
	public static function tearDownAfterClass(): void
	{
		$_SERVER = self::$server;
	}
}