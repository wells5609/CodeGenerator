<?php

namespace CodeGen;

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
