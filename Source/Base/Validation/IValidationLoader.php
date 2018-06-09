<?php
namespace WebCore\Base\Validation;


interface IValidationLoader
{
	public function invoke(callable $callback, array $args = []);
}