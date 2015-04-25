<?php

namespace CodeGen\Php;

use CodeGen\AbstractObject;
use CodeGen\Functionality\Abstractable;
use CodeGen\Functionality\Finalable;
use CodeGen\ClassIntrospector;

class Class_ extends AbstractObject
{
	use Abstractable, Finalable;
	
	protected $parent;
	protected $interfaces = [];
	protected $properties = [];
	protected $methods = [];
	
	public function setParent($classname) {
		if (! is_string($classname)) {
			throw new \InvalidArgumentException("Expecting string, given: ".gettype($classname));
		}
		$this->parent = trim($classname, '\\');
		return $this;
	}
	
	public function getParent() {
		return $this->getCanvas()->escapeClassname($this->parent);
	}
	
	public function hasParent() {
		return isset($this->parent);
	}
	
	public function addInterface($interface) {
		$interface = trim($interface, '\\');
		if (! isset($this->interfaces[$interface])) {
			$this->interfaces[$interface] = $interface;
			ClassIntrospector::addMethodsToClass($this, $interface);
		}
		return $this;
	}
	
	public function addProperty($name, $visibility = 'public') {
	
		if ($name instanceof Property) {
			$this->properties[$name->getName()] = $name;
			return $name;
		} 
		
		if (! is_string($name)) {
			throw new \InvalidArgumentException("Expecting Property or string");
		}
	
		$this->properties[$name] = $prop = new Property($this->getCanvas());
		$prop->setName($name);
		$prop->setVisibility($visibility);
	
		return $prop;
	}
	
	public function addMethod($name, $visibility = 'public') {
		
		if ($name instanceof Method) {
			$this->methods[$name->getName()] = $name;
			return $name;
		} 
		
		if (! is_string($name)) {
			throw new \InvalidArgumentException("Expecting Method or string");
		}
		
		$this->methods[$name] = $method = new Method($this->getCanvas());
		$method->setName($name);
		$method->setVisibility($visibility);
		
		return $method;
	}
	
	public function __toString() {
		
		$str = '';
		
		if ($this->isAbstract()) {
			$str .= 'abstract ';
		} else if ($this->isFinal()) {
			$str .= 'final ';
		}
		
		$str .= 'class ' . $this->getName();
		
		if ($this->hasParent()) {
			$str .= ' extends ' . $this->getParent();
		}
		
		if (! empty($this->interfaces)) {
			$str .= ' implements ' . implode(', ', array_map(array($this->canvas, 'escapeClassname'), $this->interfaces));
		}
		
		$str .= "\n{\n";
		
		foreach($this->properties as $prop) {
			$str .= $prop;
		}
		
		foreach($this->methods as $method) {
			$str .= $method;
		}
		
		$str .= "\n}\n";
		
		return $str;
	}
	
	public function __call($func, array $args) {
		if ('implements' === $func) {
			return $this->addInterface($args[0]);
		} else if ('extends' === $func) {
			return $this->setParent($args[0]);
		}
		throw new \BadMethodCallException("Invalid method: '{$func}'");
	}
}
