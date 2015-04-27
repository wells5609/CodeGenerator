<?php

namespace CodeGen\Lang;

class Assignment extends Expression
{
	
	protected $mid = '=';
	
	public function setLeft($leftValue) {
		if (! $this->scope->symbolTable->exists($leftValue)) {
			$this->scope->symbolTable->reserve($leftValue);
		}
		$this->left = SymbolTable::varname($leftValue);
		return $this;
	}
	
	public function setMid($midValue) {
		throw new \RuntimeException("Assignments always use the '=' operator");
	}
	
	public function setRight($rightValue) {
		$this->scope->symbolTable->set($this->left, trim($rightValue));
		$this->right = trim($rightValue);
		return $this;
	}
	
	protected function stringAfter() {
		return ";\n";
	}
	
}
