<?php
namespace WebCore\Base\Validation;


use WebCore\IInput;


interface IWithSource
{
	/**
	 * @param IInput $source
	 * @return IWithSource|static
	 */
	public function setSource(IInput $source): IWithSource;
}