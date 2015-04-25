<?php

namespace CodeGen\Functionality;

trait Finalable
{
	protected $isFinal = false;
	
	public function setFinal() {
		$this->isFinal = true;
		return $this;
	}
	
	public function isFinal() {
		return $this->isFinal;
	}
}
