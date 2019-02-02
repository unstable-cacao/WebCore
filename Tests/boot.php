<?php
require_once __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ERROR | E_PARSE);


function resetStaticDataMember(string $className, string $memberName)
{
	$reflectionClass = new ReflectionClass($className);
	$property = $reflectionClass->getProperty($memberName);
	$property->setAccessible(true);
	$property->setValue($reflectionClass, null);
}

/**
 * @param string $className
 * @param string $memberName
 * @param mixed $value
 * @return mixed $classInstance
 */
function resetInstanceDataMember(string $className, string $memberName, $value)
{
	$reflectionClass = new ReflectionClass($className);
	$instance = $reflectionClass->newInstance();
	
	$property = $reflectionClass->getProperty($memberName);
	$property->setAccessible(true);
	$property->setValue($instance, $value);
	
	return $instance;
}