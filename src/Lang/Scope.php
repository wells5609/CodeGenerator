<?php

namespace CodeGen\Lang;

use CodeGen\Canvas;

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

class SymbolTable implements \ArrayAccess, \Countable
{
	
	public $scope;
	protected $variables = [];
	private $anonVarNum = 0;
	
	public function __construct(Scope $scope) {
		$this->scope = $scope;
	}
	
	public function set($name, $value) {
		$this->variables[self::varname($name)] = $value;
		return $this;
	}
	
	public function get($name) {
		$name = self::varname($name);
		return array_key_exists($name, $this->variables) ? $this->variables[$name] : null;
	}
	
	public function exists($name) {
		return array_key_exists(self::varname($name), $this->variables);
	}
	
	public function delete($name) {
		unset($this->variables[self::varname($name)]);
		return $this;
	}
	
	public function getAll() {
		return $this->variables;
	}
	
	public function getAnonymousVariable() {
		$var = '_'.$this->anonVarNum;
		$this->set($var, null);
		$this->anonVarNum++;
		return $var;
	}
	
	public function count() {
		return count($this->variables);
	}
	
	public function offsetSet($index, $newval) {
		$this->set($index, $newval);
	}
	
	public function offsetGet($index) {
		return $this->get($index);
	}
	
	public function offsetExists($index) {
		return $this->exists($index);
	}
	
	public function offsetUnset($index) {
		$this->delete($index);
	}
	
	public function reserve($name) {
		return $this->set($name, null);
	}
	
	public function add($name, $value) {
		return $this->set($name, $value);
	}
	
	public function has($name) {
		return $this->exists($name);
	}
	
	public function remove($name) {
		return $this->delete($name);
	}
	
	public static function varname($varname) {
		return '$'.trim(ltrim($varname, '$'));
	}
}
