<?php
namespace WebCore\HTTP\Utilities;


use PHPUnit\Framework\TestCase;
use WebCore\HTTP\Requests\StandardWebRequest;


class UserAgentExtractorTest extends TestCase
{
	protected function setUp()
	{
		$_SERVER = [];
		resetStaticDataMember(HeadersLoader::class, 'headers');
	}
	
	
	public function test_get_UserAgentInRequestHeader_ReturnUserAgent()
	{
		$_SERVER['HTTP_USER_AGENT'] = 'Test';
		$request = new StandardWebRequest();
		$request->getHeaders();
		
		$_SERVER['HTTP_USER_AGENT'] = 'Test2';
		
		self::assertEquals('Test', UserAgentExtractor::get($request, 'Test3'));
	}
	
	public function test_get_UserAgentInGlobal_ReturnUserAgent()
	{
		$request = new StandardWebRequest();
		$request->getHeaders();
		
		$_SERVER['HTTP_USER_AGENT'] = 'Test2';
		
		self::assertEquals('Test2', UserAgentExtractor::get($request, 'Test3'));
	}
	
	public function test_get_NoUserAgent_ReturnDefault()
	{
		$request = new StandardWebRequest();
		$request->getHeaders();
		
		self::assertEquals('Test3', UserAgentExtractor::get($request, 'Test3'));
	}
	
	
	public static function tearDownAfterClass()
	{
		$_SERVER = [];
	}
}