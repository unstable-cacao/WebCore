<?php
namespace WebCore\HTTP\Requests;


use PHPUnit\Framework\TestCase;
use WebCore\HTTP\Utilities\HeadersLoader;
use WebCore\HTTP\Utilities\IsHTTPSValidator;
use WebCore\IInput;
use WebCore\Method;


class StandardWebRequestTest extends TestCase
{
	protected function setUp()
	{
		$_SERVER = [];
		$_GET = [];
		$_POST = [];
		resetStaticDataMember(HeadersLoader::class, 'headers');
		resetStaticDataMember(IsHTTPSValidator::class, 'isHttps');
	}
	
	
	public function test_isMethod_SameMethod_ReturnTrue()
	{
		$_SERVER['REQUEST_METHOD'] = Method::GET;
		$subject = new StandardWebRequest();
		
		self::assertTrue($subject->isMethod(Method::GET));
	}
	
	public function test_isMethod_DifferentMethod_ReturnFalse()
	{
		$_SERVER['REQUEST_METHOD'] = Method::GET;
		$subject = new StandardWebRequest();
		
		self::assertFalse($subject->isMethod(Method::POST));
	}
	
	public function test_isGet_Get_ReturnTrue()
	{
		$_SERVER['REQUEST_METHOD'] = Method::GET;
		$subject = new StandardWebRequest();
		
		self::assertTrue($subject->isGet());
	}
	
	public function test_isGet_NotGet_ReturnFalse()
	{
		$_SERVER['REQUEST_METHOD'] = Method::POST;
		$subject = new StandardWebRequest();
		
		self::assertFalse($subject->isGet());
	}
	
	public function test_isPost_Post_ReturnTrue()
	{
		$_SERVER['REQUEST_METHOD'] = Method::POST;
		$subject = new StandardWebRequest();
		
		self::assertTrue($subject->isPost());
	}
	
	public function test_isPost_NotPost_ReturnFalse()
	{
		$_SERVER['REQUEST_METHOD'] = Method::GET;
		$subject = new StandardWebRequest();
		
		self::assertFalse($subject->isPost());
	}
	
	public function test_isPut_Put_ReturnTrue()
	{
		$_SERVER['REQUEST_METHOD'] = Method::PUT;
		$subject = new StandardWebRequest();
		
		self::assertTrue($subject->isPut());
	}
	
	public function test_isPut_NotPut_ReturnFalse()
	{
		$_SERVER['REQUEST_METHOD'] = Method::GET;
		$subject = new StandardWebRequest();
		
		self::assertFalse($subject->isPut());
	}
	
	public function test_isDelete_Delete_ReturnTrue()
	{
		$_SERVER['REQUEST_METHOD'] = Method::DELETE;
		$subject = new StandardWebRequest();
		
		self::assertTrue($subject->isDelete());
	}
	
	public function test_isDelete_NotDelete_ReturnFalse()
	{
		$_SERVER['REQUEST_METHOD'] = Method::GET;
		$subject = new StandardWebRequest();
		
		self::assertFalse($subject->isDelete());
	}
	
	public function test_isHttp_HTTP_ReturnTrue()
	{
		$subject = new StandardWebRequest();
		
		self::assertTrue($subject->isHttp());
	}
	
	public function test_isHttp_NotHTTP_ReturnFalse()
	{
		$_SERVER['HTTPS'] = 'on';
		$subject = new StandardWebRequest();
		
		self::assertFalse($subject->isHttp());
	}
	
	public function test_getHeaders_ReturnIInput()
	{
		$subject = new StandardWebRequest();
		
		self::assertInstanceOf(IInput::class, $subject->getHeaders());
	}
	
	public function test_getHeader_NoHeader_ReturnDefault()
	{
		$subject = new StandardWebRequest();
		
		self::assertNull($subject->getHeader('test'));
	}
	
	public function test_hasHeader_NoHeader_ReturnFalse()
	{
		$subject = new StandardWebRequest();
		
		self::assertFalse($subject->hasHeader('test'));
	}
	
	public function test_hasHeader_Exists_ReturnTrue()
	{
		$_SERVER['HTTP_test'] = 'on';
		$subject = new StandardWebRequest();
		
		self::assertTrue($subject->hasHeader('test'));
	}
	
	public function test_getCookies_ReturnIInput()
	{
		$subject = new StandardWebRequest();
		
		self::assertInstanceOf(IInput::class, $subject->getCookies());
	}
	
	public function test_getCookiesArray_ReturnArray()
	{
		$subject = new StandardWebRequest();
		
		self::assertEquals([], $subject->getCookiesArray());
	}
	
	public function test_getCookie_NoCookie_ReturnDefault()
	{
		$subject = new StandardWebRequest();
		
		self::assertNull($subject->getCookie('test'));
	}
	
	public function test_hasCookie_NoCookie_ReturnFalse()
	{
		$subject = new StandardWebRequest();
		
		self::assertFalse($subject->hasCookie('test'));
	}
	
	public function test_hasCookie_Exists_ReturnTrue()
	{
		$_COOKIE['test'] = 'on';
		$subject = new StandardWebRequest();
		
		self::assertTrue($subject->hasCookie('test'));
	}
	
	public function test_getParams_ReturnIInput()
	{
		$subject = new StandardWebRequest();
		
		self::assertInstanceOf(IInput::class, $subject->getParams());
	}
	
	public function test_getParam_NoParam_ReturnDefault()
	{
		$subject = new StandardWebRequest();
		
		self::assertNull($subject->getParam('test'));
	}
	
	public function test_hasParam_NoParam_ReturnFalse()
	{
		$subject = new StandardWebRequest();
		
		self::assertFalse($subject->hasParam('test'));
	}
	
	public function test_hasParam_Exists_ReturnTrue()
	{
		$_GET['test'] = 'on';
		$subject = new StandardWebRequest();
		
		self::assertTrue($subject->hasParam('test'));
	}
	
	public function test_getQuery_ReturnIInput()
	{
		$subject = new StandardWebRequest();
		
		self::assertInstanceOf(IInput::class, $subject->getQuery());
	}
	
	public function test_getQueryArray_ReturnArray()
	{
		$subject = new StandardWebRequest();
		
		self::assertEquals([], $subject->getQueryArray());
	}
	
	public function test_getQueryParam_NoParam_ReturnDefault()
	{
		$subject = new StandardWebRequest();
		
		self::assertNull($subject->getQueryParam('test'));
	}
	
	public function test_hasQueryParam_NoParam_ReturnFalse()
	{
		$subject = new StandardWebRequest();
		
		self::assertFalse($subject->hasQueryParam('test'));
	}
	
	public function test_hasQueryParam_Exists_ReturnTrue()
	{
		$_GET['test'] = 'on';
		$subject = new StandardWebRequest();
		
		self::assertTrue($subject->hasQueryParam('test'));
	}
	
	public function test_getPost_ReturnIInput()
	{
		$subject = new StandardWebRequest();
		
		self::assertInstanceOf(IInput::class, $subject->getPost());
	}
	
	public function test_getPostArray_ReturnArray()
	{
		$subject = new StandardWebRequest();
		
		self::assertEquals([], $subject->getPostArray());
	}
	
	public function test_getPostParam_NoParam_ReturnDefault()
	{
		$subject = new StandardWebRequest();
		
		self::assertNull($subject->getPostParam('test'));
	}
	
	public function test_hasPostParam_NoParam_ReturnFalse()
	{
		$subject = new StandardWebRequest();
		
		self::assertFalse($subject->hasPostParam('test'));
	}
	
	public function test_hasPostParam_Exists_ReturnTrue()
	{
		$_POST['test'] = 'on';
		$subject = new StandardWebRequest();
		
		self::assertTrue($subject->hasPostParam('test'));
	}
	
	public function test_getMethod_MemberSet_ReturnMember()
	{
		$subject = new StandardWebRequest();
		$_SERVER['REQUEST_METHOD'] = Method::PUT;
		$subject->getMethod();
		
		$_SERVER['REQUEST_METHOD'] = Method::GET;
		
		self::assertEquals(Method::PUT, $subject->getMethod());
	}
	
	public function test_getMethod_MemberNotSet_ReturnFromGlobal()
	{
		$subject = new StandardWebRequest();
		$_SERVER['REQUEST_METHOD'] = Method::PUT;
		
		self::assertEquals(Method::PUT, $subject->getMethod());
	}
	
	public function test_isHttps_MemberSet_ReturnMember()
	{
		$subject = new StandardWebRequest();
		$_SERVER['HTTPS'] = 'on';
		$subject->isHttps();
		
		$_SERVER['HTTPS'] = 'off';
		
		self::assertTrue($subject->isHttps());
	}
	
	public function test_isHttps_MemberNotSet_ReturnFromGlobal()
	{
		$subject = new StandardWebRequest();
		$_SERVER['HTTPS'] = 'on';
		
		self::assertTrue($subject->isHttps());
	}
	
	public function test_getUserAgent_UserAgentNotSet_ReturnDefault()
	{
		$subject = new StandardWebRequest();
		
		self::assertNull($subject->getUserAgent());
	}
	
	public function test_getHeadersArray_MemberSet_ReturnMember()
	{
		$subject = new StandardWebRequest();
		$_SERVER['HTTP_HEADER'] = 1;
		$subject->getHeadersArray();
		
		$_SERVER = [];
		
		self::assertEquals(['HEADER' => 1], $subject->getHeadersArray());
	}
	
	public function test_getHeadersArray_MemberNotSet_ReturnFromGlobal()
	{
		$subject = new StandardWebRequest();
		$_SERVER['HTTP_HEADER'] = 1;
		
		self::assertEquals(['HEADER' => 1], $subject->getHeadersArray());
	}
	
	public function test_getParamsArray_MemberSet_ReturnMember()
	{
		$subject = new StandardWebRequest();
		$_GET['test'] = 1;
		$subject->getParamsArray();
		
		$_GET = [];
		
		self::assertEquals(['test' => 1], $subject->getParamsArray());
	}
	
	public function test_getParamsArray_MemberNotSet_ReturnFromGlobal()
	{
		$subject = new StandardWebRequest();
		$_GET['test'] = 1;
		
		self::assertEquals(['test' => 1], $subject->getParamsArray());
	}
	
	public function test_getPort_NotSet_ReturnNull()
	{
		$subject = new StandardWebRequest();
		
		self::assertNull($subject->getPort());
	}
	
	public function test_getPort_Set_ReturnPort()
	{
		$subject = new StandardWebRequest();
		$_SERVER['SERVER_PORT'] = 555;
		
		self::assertEquals(555, $subject->getPort());
	}
	
	public function test_getHost_NotSet_ReturnEmptyString()
	{
		$subject = new StandardWebRequest();
		
		self::assertEquals('', $subject->getHost());
	}
	
	public function test_getURI_NotSet_ReturnEmptyString()
	{
		$subject = new StandardWebRequest();
		
		self::assertEquals('', $subject->getURI());
	}
	
	public function test_getURL_ReturnFullURL()
	{
		$subject = new StandardWebRequest();
		$_SERVER['HTTP_HOST'] = 'test.com';
		
		
		self::assertEquals('http://test.com', $subject->getURL());
	}
}