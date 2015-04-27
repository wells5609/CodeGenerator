<?php

namespace CodeGen\Lang\Expression;

use CodeGen\Lang\Lang;

class IfStatement extends Decorator 
{
	
	public function setMid($midValue) {
		if (! Lang::isComparator($midValue)) {
			throw new \InvalidArgumentException("Invalid comparator");
		}
		$this->expression->setMid($midValue);
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
}
