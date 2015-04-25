<?php

namespace CodeGen;

abstract class AbstractObject implements ObjectInterface
{
	use Functionality\Documentable;
	
	protected $canvas;
	protected $name;
	
	public function __construct(Canvas $canvas, $name = null) {
		$this->canvas = $canvas;
		if (isset($name)) {
			$this->setName($name);
		}
	}
	
	public function setName($name) {
		if (! is_string($name)) {
			throw new \InvalidArgumentException("Expecting string, given: ".gettype($name));
		}
		$this->name = $name;
		return $this;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getCanvas() {
		return $this->canvas;
	}
	
	abstract public function __toString();
}
