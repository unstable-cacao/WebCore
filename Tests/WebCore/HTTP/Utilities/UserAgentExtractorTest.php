<?php
namespace WebCore\HTTP\Utilities;


use PHPUnit\Framework\TestCase;
use WebCore\WebRequest;


class UserAgentExtractorTest extends TestCase
{
	private static array $server = [];
	
	
	protected function setUp(): void
	{
		$_SERVER = [];
		
		resetStaticDataMember(HeadersLoader::class, 'exactHeaders');
		resetStaticDataMember(HeadersLoader::class, 'lowerCaseHeaders');
	}
	
	
	public function test_get_UserAgentInRequestHeader_ReturnUserAgent()
	{
		$_SERVER['HTTP_User-Agent'] = 'Test';
		$request = new WebRequest();
		$request->getHeaders(true);
		
		self::assertEquals('Test', UserAgentExtractor::get($request, 'Test3'));
	}
	
	public function test_get_NoUserAgent_ReturnDefault()
	{
		$request = new WebRequest();
		$request->getHeaders();
		
		self::assertEquals('Test3', UserAgentExtractor::get($request, 'Test3'));
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