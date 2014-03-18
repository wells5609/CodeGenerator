<?php

namespace CodeGenerator;

class GeneratedClass extends GeneratedObject {
	
	public $class;
	
	public $parent;
	
	public $interfaces = array();
	
	public $properties = array();
	
	public $methods = array();
	
	public $predefined_methods = array();
	
	public function __construct($classname = null) {
		if (isset($classname)) {
			$this->class = $classname;
		}
	}
	
	public function setTemplate($tmpl) {
		$this->template = $tmpl;
		return $this;
	}
	
	public function setClass( $class ) {
		$this->class = $class;
		return $this;
	}
	
	public function setParent( $class ) {
		$this->parent = $class;
		return $this;
	}
	
	public function addInterface( $interface ) {
		$this->interfaces[] = $interface;
		return $this;
	}
	
	public function addProperty($name, $type, $visibility = 'public') {
		$this->properties[$visibility][$name] = $type;
		return $this;
	}
	
	public function addMethod( $method, array $args = array(), $visibility = 'public') {
		$this->methods[$visibility][$method] = $args;
		return $this;
	}
	
	public function addPredefinedMethod( $classname ) {
		$this->predefined_methods[] = $classname;
		return $this;
	}
	
	
}
