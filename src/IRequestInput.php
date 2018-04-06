<?php
namespace WebCore;


interface IRequestInput
{
	public function get(): IInput;
	public function post(): IInput;
	public function cookies(): IInput;
	public function headers(): IInput;
	public function params(): IInput;
	public function request(): IRequest;
	public function method(): string;
}