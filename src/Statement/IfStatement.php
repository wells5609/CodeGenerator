<?php

namespace CodeGen\Statement;

use CodeGen\Expression;
use CodeGen\Lang;

class IfStatement extends Expression 
{
	
	public function setMid($midValue) {
		if (! Lang::isComparator($midValue)) {
			throw new \InvalidArgumentException("Invalid comparator");
		}
		$this->mid = trim($midValue);
		return $this;
	}
	
	public function setComparator($cmp) {
		return $this->setMid($cmp);
	}
	
	protected function stringBefore() {
		return 'if (';		
	}
	
	protected function stringAfter() {
		return ') ';
	}
	
	public function addElseIf(Statement $statement) {}
}
