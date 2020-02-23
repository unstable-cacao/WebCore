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
 * @property string|null	$SameSite
 */
class Cookie extends LiteObject
{
	/**
	 * Allow cookies to be set when request is generated from any domain.
	 */
	public const SAME_SITE_NONE		= SameSite::NONE;
	
	/**
	 * Allow same site request ONLY, and don't allow cookies to be passed whe nredirected from a different domain.
	 */
	public const SAME_SITE_STRICT	= SameSite::STRICT;
	
	/**
	 * Allow same site request ONLY. 
	 */
	public const SAME_SITE_LAX		= SameSite::LAX;
	
	
	private function isSetCookiesUseArray(): bool
	{
		if (PHP_MAJOR_VERSION < 7)
			return false;
		
		if (PHP_MAJOR_VERSION == 7 && PHP_MINOR_VERSION < 3)
			return false;
		
		return true;
	}
	
	
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
			'ServerOnly'	=> LiteSetup::createBool(false),
			'SameSite'		=> LiteSetup::createString(self::SAME_SITE_LAX)
		];
	}
	
	
	public function apply(): void
	{
		if ($this->isSetCookiesUseArray())
		{
			setcookie(
				$this->Name, 
				$this->Value, 
				[
					'expires'	=> $this->Expire,     
					'path'		=> $this->Path,       
					'domain'	=> $this->Domain,     
					'secure'	=> $this->Secure,     
					'httponly'	=> $this->ServerOnly,  
					'samesite'	=> $this->SameSite
				]
			);
		}
		else
		{
			$path = $this->Path;
			
			if ($this->SameSite)
			{
				$path = "$path; samesite={$this->SameSite}";
			}
			
			setcookie(
				$this->Name, 
				$this->Value, 
				$this->Expire, 
				$path, 
				$this->Domain, 
				$this->Secure, 
				$this->ServerOnly
			);
		}
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
	
	public function setSameSite(?string $value): void
	{
		if (is_null($value))
			$value = SameSite::LAX;
		
		$this->SameSite = $value;
	}
	
	
	/**
	 * @param string $name
	 * @param null|string $value
	 * @param int|string $expire
	 * @param null|string|array $path
	 * @param null|string $domain
	 * @param bool $secure
	 * @param bool $serverOnly
	 * @param string|null $sameSite
	 * @return Cookie
	 */
	public static function create(
		string $name, 
		?string $value = null, 
		$expire = 0, 
		$path = null, 
		?string $domain = null, 
		bool $secure = false, 
		bool $serverOnly = false,
		?string $sameSite = null): Cookie
	{
		$cookie = new Cookie();
		
		if (is_array($path))
		{
			$expire		= $path['expires'] ?? 0;    
			$domain		= $path['domain'] ?? null;    
			$secure		= $path['secure'] ?? false;    
			$serverOnly	= $path['httponly'] ?? false; 
			$sameSite	= $path['samesite'] ?? null;
			
			$path		= $path['path'] ?? null;      
		}
		
		$cookie->Name		= $name;
		$cookie->Value		= $value; 
		$cookie->Path		= $path; 
		$cookie->Domain		= $domain; 
		$cookie->Secure		= $secure; 
		$cookie->ServerOnly	= $serverOnly;
		
		$cookie->expireAt($expire); 
		$cookie->setSameSite($sameSite);
		
		return $cookie;
	}
	
	/**
	 * @param string $name
	 * @param null|string $value
	 * @param int|string $expire
	 * @param null|string|array $path
	 * @param null|string $domain
	 * @param bool $secure
	 * @param bool $serverOnly
	 * @param string|null $sameSite
	 * @return Cookie
	 */
	public static function applyCookie(
		string $name, 
		?string $value = null, 
		$expire = 0, 
		$path = null, 
		?string $domain = null, 
		bool $secure = false, 
		bool $serverOnly = false,
		?string $sameSite = null): Cookie
	{
		$cookie = self::create($name, $value, $expire, $path, $domain, $secure, $serverOnly, $sameSite);
		$cookie->apply();
		return $cookie;
	}
	
	public static function delete(
		string $name,
		string $path = '/',
		string $sameSite = SameSite::LAX
	): Cookie
	{
		$secured = ($sameSite == SameSite::NONE) ? true : false;
		return Cookie::create($name, null, '-1 day', $path, null, $secured, false, $sameSite);
	}
	
	public static function applyDelete(
		string $name,
		string $path = '/',
		string $sameSite = SameSite::LAX
	): Cookie
	{
		$cookie = self::delete($name, $path, $sameSite);
		$cookie->apply();
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