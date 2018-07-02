<?php
namespace WebCore\HTTP\Utilities;


use PHPUnit\Framework\TestCase;


class HeadersLoaderTest extends TestCase
{
	protected function setUp()
	{
		$_SERVER = [];
		resetStaticDataMember(HeadersLoader::class, 'headers');
	}
	
	
	public function test_getAllHeaders_HeadersMemberNotNull_ReturnMember()
	{
		HeadersLoader::getAllHeaders();
		
		$_SERVER['CONTENT_LENGTH'] = 5;
		
		self::assertEquals([], HeadersLoader::getAllHeaders());
	}
	
	public function test_getAllHeaders_ServerGlobalSet_ReturnUniqueHeaders()
	{
		$_SERVER['CONTENT_LENGTH'] 	= 50;
		$_SERVER['CONTENT_TYPE'] 	= 'TestType';
		
		self::assertEquals([
			'CONTENT_LENGTH' 	=> 50,
			'CONTENT_TYPE'		=> 'TestType'
		], HeadersLoader::getAllHeaders());
	}
	
	public function test_getAllHeaders_ServerGlobalSet_StripHttpPrefix()
	{
		$_SERVER['HTTP_HEADER_A'] = 'test';
		$_SERVER['HTTP_HEADER_B'] = 555;
		
		self::assertEquals([
			'HEADER_A' => 'test',
			'HEADER_B' => 555
		], HeadersLoader::getAllHeaders());
	}
	
	public function test_getAllHeaders_NoHeaders_ReturnEmptyArray()
	{
		self::assertEquals([], HeadersLoader::getAllHeaders());
	}
	
	
	public static function tearDownAfterClass()
	{
		$_SERVER = [];
	}
}