<?php

namespace CodeGen\Lang;

class Comparison extends Expression
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
