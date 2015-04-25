<?php

namespace CodeGen\Functionality;

trait Staticable
{
	protected $isStatic = false;
	
	public function setStatic() {
		$this->isStatic = true;
		return $this;
	}
	
	public function isStatic() {
		return $this->isStatic;
	}
}
