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
			'ServerOnly'	=> LiteSetup::createBool(false)
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
	 * @param string $name
	 * @param null|string $value
	 * @param int|string $expire
	 * @param null|string $path
	 * @param null|string $domain
	 * @param bool $secure
	 * @param bool $serverOnly
	 * @return Cookie
	 */
	public static function create(
		string $name, 
		?string $value = null, 
		$expire = 0, 
		?string $path = null, 
		?string $domain = null, 
		bool $secure = false, 
		bool $serverOnly = false) : Cookie
	{
		$cookie = new Cookie();
		
		$cookie->Name		= $name;
		$cookie->Value		= $value; 
		$cookie->expireAt($expire); 
		$cookie->Path		= $path; 
		$cookie->Domain		= $domain; 
		$cookie->Secure		= $secure; 
		$cookie->ServerOnly	= $serverOnly; 
		
		return $cookie;
	}
	
	/**
	 * @param string $name
	 * @param null|string $path
	 * @param null|string $domain
	 * @param bool $secure
	 * @param bool $serverOnly
	 * @return Cookie
	 */
	public static function delete(
		string $name,
		?string $path = null,
		?string $domain = null,
		bool $secure = false,
		bool $serverOnly = false) : Cookie
	{
		$cookie = new Cookie();
		
		$cookie->Name		= $name;
		$cookie->Value		= null;
		$cookie->expireAt(time() - 60);
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