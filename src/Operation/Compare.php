<?php

namespace CodeGen\Operation;

use CodeGen\Expression;
use CodeGen\Lang;

class Compare extends Expression
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
}
