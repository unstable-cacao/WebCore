<?php
namespace WebCore\Base\HTTP;


interface IRequestFiles
{
	/**
	 * @return IRequestFile[]
	 */
	public function all(): array;

	/**
	 * @return IRequestFile[]
	 */
	public function errors(): array;
	
	public function hasErrors();
	
}