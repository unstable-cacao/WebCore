<?php
namespace WebCore\Base\Validation;


interface IValidationLoader
{
	public function invoke($object, string $method, array $args = []);
}