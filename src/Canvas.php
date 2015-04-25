<?php

namespace CodeGen;

class Canvas
{
	protected $namespace;
	protected $uses = [];
	protected $objects = [];
	private $currentContext;
	
	public function setNamespace($namespace) {
		if (! is_string($namespace)) {
			throw new \InvalidArgumentException("Expecting string, given: ".gettype($namespace));
		}
		$this->namespace = $namespace;
		return $this;
	}
	
	public function getNamespace() {
		return $this->namespace;
	}
	
	public function addUse($class, $as = null) {
		if (! isset($as)) {
			$as = self::classBasename($class);
		}
		if (isset($this->uses[$as])) {
			throw new \InvalidArgumentException("Namespace already uses: '{$as}'.");
		}
		$this->uses[$as] = $class;
		return $this;
	}
	
	public function getAlias($class) {
		return array_search($class, $this->uses, true);
	}
	
	public function escapeClassname($class) {
		if ($alias = $this->getAlias($class)) {
			return $alias;
		}
		if ($this->namespace && 0 === strpos($class, $this->namespace)){
			return substr($class, strlen($this->namespace)+1);
		}
		return '\\' . $class;
	}
	
	public function addObject(ObjectInterface $object) {
		$this->objects[$object->getName()] = $object;
		if (method_exists($object, 'init')) {
			$object->init();
		}
		return $this;
	}
	
	public function __toString() {
		$str = "\nnamespace " . $this->getNamespace() . "; \n\n";
		foreach($this->uses as $alias => $class) {
			$str .= 'use ' . $class;
			if ($alias != self::classBasename($class)) {
				$str .= ' as ' . $alias;
			}
			$str .= ";\n";
		}
		$str .= "\n";
		foreach($this->objects as $object) {
			$str .= $object;
		}
		return $str;
	}
	
	public function setCurrentContext($context) {
		$this->currentContext = $context;
	}
	
	public function getCurrentContext() {
		return $this->currentContext;
	}
	
	public function __call($func, array $args) {
		if ('use' === $func) {
			return call_user_func_array(array($this, 'addUse'), $args);
		}
		throw new \BadMethodCallException("Method '{$func}' does not exist");
	}
	
	public static function classBasename($classname) {
		return basename(str_replace('\\', '/', $classname));
	}
	
}
