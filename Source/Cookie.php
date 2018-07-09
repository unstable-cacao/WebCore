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
	
	public static function create(
		$name, 
		$value = null, 
		$expire = 0, 
		$path = null, 
		$domain = null, 
		$secure = false, 
		$serverOnly = false) : Cookie
	{
		$cookie = new Cookie();
		
		$cookie->Name		= $name;
		$cookie->Value		= $value; 
		$cookie->Expire		= $expire; 
		$cookie->Path		= $path; 
		$cookie->Domain		= $domain; 
		$cookie->Secure		= $secure; 
		$cookie->ServerOnly	= $serverOnly; 
		
		return $cookie;
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