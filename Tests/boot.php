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