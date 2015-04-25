<?php

namespace CodeGen\Functionality;

trait Typeable
{
	protected $type;
	
	public static $recognizedTypes = array('string', 'array', 'bool', 'boolean', 'int', 'integer', 'float', 'double');
	
	public function setType($type) {
		if (! is_string($type)) {
			throw new \InvalidArgumentException("Expecting string, given: ".gettype($type));
		}
		if (in_array($typeLower = strtolower($type), self::$recognizedTypes, true)) {
			$this->type = $typeLower;
		} else {
			$this->type = $type;
		}
		return $this;
	}
	
	public function hasType() {
		return isset($this->type);
	}
	
	public function getType() {
		return $this->type;
	}
	
	public function isType($type) {
		return isset($this->type) ? $type === $this->type : false;
	}
	
	public function isTypeArray() {
		return isset($this->type) ? 'array' === $this->type : false;
	}
	
	public function isTypeString() {
		return isset($this->type) ? 'string' === $this->type : false;
	}
	
}
