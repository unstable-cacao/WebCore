<?php
namespace WebCore;


use Objection\LiteObject;
use Objection\LiteSetup;


/**
 * @property string 		$Name
 * @property string|null	$Value
 * @property int			$Expire
 * @property string|null	$Path 
 * @property string|null	$Domain
 * @property bool			$Secure
 * @property bool			$ServerOnly
 */
class Cookie extends LiteObject
{
	/**
	 * @return array
	 */
	protected function _setup()
	{
		return [
			'Name'			=> LiteSetup::createString(),
			'Value'			=> LiteSetup::createString(null),
			'Expire'		=> LiteSetup::createInt(0),
			'Path'			=> LiteSetup::createString(null),
			'Domain'		=> LiteSetup::createString(null),
			'Secure'		=> LiteSetup::createBool(false),
			'ServerOnly'	=> LiteSetup::createString(false)
		];
	}
	
	
	public function apply(): void
	{
		setcookie(
			$this->Name, 
			$this->Value, 
			$this->Expire, 
			$this->Path, 
			$this->Domain, 
			$this->Secure, 
			$this->ServerOnly
		);
	}
	
	/**
	 * @param string|int $time
	 * @return Cookie
	 */
	public function expireAt($time): Cookie
	{
		if (is_int($time))
			$this->Expire = $time;
		else
			$this->Expire = strtotime($time);
		
		return $this;
	}
	
	
	/**
	 * @param Cookie[] $cookies
	 */
	public static function applyAll(array $cookies): void
	{
		foreach ($cookies as $cookie)
		{
			$cookie->apply();
		}
	}
}