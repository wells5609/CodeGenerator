<?php

namespace CodeGen;

class Scope
{
	const SCOPE_GLOBAL = 0;
	const SCOPE_CLASS = 1;
	const SCOPE_FUNCTION = 2;
	const SCOPE_CLOSURE = 3;
	
	public $symbolTable;
	protected $canvas;
	protected $scope;
	
	public function __construct(Canvas $canvas, $scope) {
		$this->canvas = $canvas;
		$this->symbolTable = new SymbolTable($this);
		$this->scope = $scope;
	}
	
	public function getCanvas() {
		return $this->canvas;
	}
	
	public function getScope() {
		return $this->scope;
	}
	
	public function isScope($type) {
		return $type === $this->scope;
	}
	
	public function isScopeGlobal() {
		return $this->isScope(self::SCOPE_GLOBAL);
	}
	
	public function isScopeClass() {
		return $this->isScope(self::SCOPE_CLASS);
	}
	
	public function isScopeFunction() {
		return $this->isScope(self::SCOPE_FUNCTION);
	}
	
	public function isScopeClosure() {
		return $this->isScope(self::SCOPE_CLOSURE);
	}
	
	public function getVar($name) {
		return $this->symbolTable->get($name);
	}
	
	public function setVar($name, $value) {
		$this->symbolTable->set($name, $value);
		return $this;
	}
	
	public function hasVar($name) {
		return $this->symbolTable->exists($name);
	}
	
	public function deleteVar($name) {
		return $this->symbolTable->delete($name);
	}
	
	public function copyTo(Scope $scope) {
		foreach($this->symbolTable->getAll() as $name => $value) {
			$scope->symbolTable->set($name, $value);
		}
		return $scope;
	}
	
	public static function createCopy(Scope $scope, $newScope = null) {
		$newObj = new self($scope->getCanvas(), $newScope ?: $scope->getScope());
		$scope->copyTo($newObj);
		return $newObj;
	}
	
}
