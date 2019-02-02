<?php
namespace WebCore\HTTP\Utilities;


use PHPUnit\Framework\TestCase;
use WebCore\HTTP\Requests\StandardWebRequest;


class UserAgentExtractorTest extends TestCase
{
	protected function setUp()
	{
		$_SERVER = [];
		
		resetStaticDataMember(HeadersLoader::class, 'exactHeaders');
		resetStaticDataMember(HeadersLoader::class, 'lowerCaseHeaders');
	}
	
	
	public function test_get_UserAgentInRequestHeader_ReturnUserAgent()
	{
		$_SERVER['HTTP_User-Agent'] = 'Test';
		$request = new StandardWebRequest();
		$request->getHeaders();
		
		self::assertEquals('Test', UserAgentExtractor::get($request, 'Test3'));
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