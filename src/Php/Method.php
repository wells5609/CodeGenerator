<?php

namespace CodeGen\Php;

use CodeGen\AbstractObject;
use CodeGen\Functionality\VisibilitySettable;
use CodeGen\Functionality\Staticable;
use CodeGen\Functionality\Abstractable;
use CodeGen\Functionality\Finalable;

class Method extends AbstractObject
{
	use VisibilitySettable, Staticable, Abstractable, Finalable;
	
	protected $params = [];
	protected $returnType;
	
	public function addParam($name, $type = null) {
		
		if ($name instanceof Parameter) {
			$this->params[$name->getName()] = $name;
			return $name;
		}
		
		if (! is_string($name)) {
			throw new \InvalidArgumentException("Expecting PhpParameter or string");
		}
		
		$this->params[$name] = $param = new Parameter($this->getCanvas());
		
		$param->setName($name);
		
		if (isset($type)) {
			$param->setType($type);
		}
		
		return $param;
	}
	
	public function getParams() {
		return $this->params;
	}
	
	public function __toString() {
		
		$str = '';
		
		if (isset($this->docs)) {
			$str .= $this->docs->render();
		}
		
		$str .= "\n\t" . $this->getVisibility() . ' function '. $this->getName() . '(';
		
		if ($this->params){
			$str .= implode(', ', array_map('strval', $this->params));
		}
		
		$str .= ") {\n\t}\n";
		
		return $str;
	}
	
	public function addParameter($name, $type = null) {
		return $this->addParam($name, $type);
	}
	
	public function getParameters() {
		return $this->getParams();
	}
}
