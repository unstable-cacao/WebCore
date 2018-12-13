<?php
namespace WebCore;


use PHPUnit\Framework\TestCase;


class CookieTest extends TestCase
{
	public function test_expireAt_Int_SetInt()
	{
		$cookie = new Cookie();
		$time = 555;
		
		self::assertEquals($time, $cookie->expireAt($time)->Expire);
	}
	
	public function test_expireAt_String_ConvertToInt()
	{
		$cookie = new Cookie();
		$timeString = '2018-01-01';
		$timeInt = strtotime($timeString);
		
		self::assertEquals($timeInt, $cookie->expireAt($timeString)->Expire);
	}
	
	public function test_create_ReturnCreatedCookie()
	{
		$cookieName = 'Test';
		$cookie = Cookie::create($cookieName);
		
		self::assertInstanceOf(Cookie::class, $cookie);
		self::assertEquals($cookieName, $cookie->Name);
	}
	
	public function test_delete_ReturnDeletedCookie()
	{
		$cookieName = 'Test';
		$cookie = Cookie::delete($cookieName);
		
		self::assertInstanceOf(Cookie::class, $cookie);
		self::assertEquals($cookieName, $cookie->Name);
		self::assertNull($cookie->Value);
		self::assertTrue($cookie->Expire < time());
	}
	
	public function test_apply()
	{
		$cookie = new Cookie();
		$cookie->Name = 'testCookie';
		
		$cookie->apply();
		
		self::assertTrue(true);
	}
	
	public function test_applyAll()
	{
		$cookieMock1 = $this->getMockBuilder(Cookie::class)->getMock();
		$cookieMock1->expects($this->once())->method('apply');
		
		$cookieMock2 = $this->getMockBuilder(Cookie::class)->getMock();
		$cookieMock2->expects($this->once())->method('apply');
		
		Cookie::applyAll([$cookieMock1, $cookieMock2]);
	}
}