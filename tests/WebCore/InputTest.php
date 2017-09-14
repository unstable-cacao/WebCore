<?php
namespace WebCore;


use PHPUnit\Framework\TestCase;


class InputTest extends TestCase
{
	private function assertIsMethodType(string $expected, string $targetFunction)
	{
		$_SERVER['REQUEST_METHOD'] = $expected;
		self::assertTrue(call_user_func([Input::class, $targetFunction]));
		
		$_SERVER['REQUEST_METHOD'] = $expected == Method::GET ? Method::POST : Method::GET;
		self::assertFalse(call_user_func([Input::class, $targetFunction]));
		
		$_SERVER['REQUEST_METHOD'] = ucfirst(strtolower($expected));
		self::assertTrue(call_user_func([Input::class, $targetFunction]));
	}
	
	
	public function test_isGet()
	{
		$this->assertIsMethodType(Method::GET, 'isGet');
	}
	
	public function test_isHead()
	{
		$this->assertIsMethodType(Method::HEAD, 'isHead');
	}
	
	public function test_isPost()
	{
		$this->assertIsMethodType(Method::POST, 'isPost');
	}
	
	public function test_isPut()
	{
		$this->assertIsMethodType(Method::PUT, 'isPut');
	}
	
	public function test_isDelete()
	{
		$this->assertIsMethodType(Method::DELETE, 'isDelete');
	}
	
	public function test_isOptions()
	{
		$this->assertIsMethodType(Method::OPTIONS, 'isOptions');
	}
	
	public function test_is_MethodsMatch_ReturnTrue()
	{
		$_SERVER['REQUEST_METHOD'] = 'GET';
		self::assertTrue(Input::is(Method::GET));
	}
	
	public function test_is_MethodsMismatch_ReturnFalse()
	{
		$_SERVER['REQUEST_METHOD'] = 'GET';
		self::assertFalse(Input::is(Method::POST));
	}
	
	public function test_is_MethodsHaveDifferentCase_ReturnTrue()
	{
		$_SERVER['REQUEST_METHOD'] = 'Get';
		self::assertTrue(Input::is(Method::GET));
	}
	
	public function test_method_MethodValid_ReturnMethod()
	{
		$_SERVER['REQUEST_METHOD'] = 'GET';
		self::assertEquals(Method::GET, Input::method());
	}
	
	public function test_method_MethodUnknown_ReturnUnknown()
	{
		$_SERVER['REQUEST_METHOD'] = 'MyMethod';
		self::assertEquals(Method::UNKNOWN, Input::method());
	}
	
	public function test_method_MethodLowerCase_ReturnUppercase()
	{
		$_SERVER['REQUEST_METHOD'] = 'get';
		self::assertEquals(Method::GET, Input::method());
	}
	
	public function test_get_ReturnIInput()
	{
		self::assertInstanceOf(IInput::class, Input::get());
	}
	
	public function test_get_UseGetGlobal()
	{
		$_GET = ['test' => '1'];
		
		self::assertTrue(Input::get()->has('test'));
	}
	
	public function test_post_ReturnIInput()
	{
		self::assertInstanceOf(IInput::class, Input::post());
	}
	
	public function test_post_UsePostGlobal()
	{
		$_POST = ['test' => '1'];
		
		self::assertTrue(Input::post()->has('test'));
	}
	
	public function test_cookies_ReturnIInput()
	{
		self::assertInstanceOf(IInput::class, Input::cookies());
	}
	
	public function test_cookies_UseCookiesGlobal()
	{
		$_COOKIE = ['test' => '1'];
		
		self::assertTrue(Input::cookies()->has('test'));
	}
	
	public function test_headers_ReturnIInput()
	{
		self::assertInstanceOf(IInput::class, Input::headers());
	}
	
	public function test_headers_HeaderException_ReturnHeader()
	{
		$_SERVER = ['CONTENT_LENGTH' => 1];
		
		self::assertTrue(Input::headers()->has('CONTENT_LENGTH'));
	}
	
	public function test_headers_ReturnOnlyHeaders()
	{
		$_SERVER = ['HTTP_HEADER1' => 1, 'OTHER_KEY' => 2];
		
		self::assertFalse(Input::headers()->has('OTHER_KEY'));
	}
	
	public function test_headers_StripHTTPPrefix()
	{
		$_SERVER = ['HTTP_HEADER1' => 1];
		
		self::assertTrue(Input::headers()->has('HEADER1'));
	}
	
	public function test_session_ReturnIInput()
	{
		self::assertInstanceOf(IInput::class, Input::session());
	}
	
	public function test_session_UseSessionGlobal()
	{
		$_SESSION = ['test' => '1'];
		
		self::assertTrue(Input::session()->has('test'));
	}
}