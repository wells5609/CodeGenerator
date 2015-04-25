<?php

namespace CodeGen\Functionality;

trait Abstractable
{
	protected $isAbstract = false;
	
	public function setAbstract() {
		$this->isAbstract = true;
		return $this;
	}
	
	public function isAbstract() {
		return $this->isAbstract;
	}
}
