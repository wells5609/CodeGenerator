<?php

namespace CodeGen\Lang;

class Operation extends Expression
{
	
	public function setMid($midValue) {
		if (! Lang::isOperator($midValue)) {
			throw new \InvalidArgumentException("Invalid operator");
		}
		$this->mid = trim($midValue);
		return $this;
	}
	
	public function setOperator($oper) {
		return $this->setMid($oper);
	}
}
