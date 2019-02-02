<?php
namespace WebCore\HTTP\Responses;


use PHPUnit\Framework\TestCase;


class StandardWebResponseTest extends TestCase
{
	public function test_sanity()
	{
		$subject = new StandardWebResponse();
		
		self::assertTrue($subject->getIsHeaderOverride());
		$subject->setIsHeaderOverride(false);
		self::assertFalse($subject->getIsHeaderOverride());
		
		self::assertEquals([], $subject->getHeaders());
		
		self::assertEquals(200, $subject->getCode());
		$subject->setCode(300);
		self::assertEquals(300, $subject->getCode());
	}
}