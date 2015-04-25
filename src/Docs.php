<?php

namespace CodeGen;

class Docs
{
	protected $str;
	protected $desc;
	protected $return;
	protected $params = [];
	protected $lines = [];
	
	public static function fromParams(array $params, $rtnType = null) {
		$block = new static();
		$block->setParams($params);
		if (isset($rtnType)) {
			$block->setReturn($rtnType);
		}
		return $block;
	}
	
	public function fromArray(array $args) {
		$doc = new static();
		if (isset($args['desc'])) {
			$doc->setDesc($args['desc']);
		}
		if (isset($args['return'])) {
			$doc->setReturn($args['return']);
		}
		if (isset($args['params'])) {
			$doc->setParams((array)$args['params']);
		}
		return $doc;
	}
	
	public static function forProperty(Php\Property $property) {
		
		$doc = new self();
		
		if ($property->hasType()) {
			$type = $property->getType();
		} else if ($property->hasDefault()) {
			$type = gettype($property->getDefault());
		} else {
			$doc->addLine("@var mixed");
		}
		
		if (isset($type)) {
			$doc->addLine("@var {$type}");
		}
		
		return $doc;
	}
	
	public function __construct($string = null) {
		if (isset($string)) {
			if (! is_string($string)) {
				throw new \InvalidArgumentException("Doc comment must be string");
			}
			$this->str = $string;
		}
	}
	
	public function setParams(array $params) {
		$this->params = $params;
	}
	
	public function setReturn($value) {
		$this->return = $value;
	}
	
	public function addLine($string) {
		$this->lines[] = $string;
	}
	
	/**
	 * Generates a docblock of params, optional return value, and optional extra lines.
	 */
	public function __toString() {
		
		if (isset($this->str)) {
			return "\n\t".$this->str;
		}
		
		$str = "\n\t/** \n\t";
		
		if (! empty($this->lines)) {
			foreach($this->lines as $line) {
				$str .= ' * ' . $line . "\n\t";
			}
		}
		
		foreach($this->params as $arg) {
			$str .= "\n\t * @param " . $arg;
		}
		
		if (isset($this->return)) {
			$str .= "\n\t * @return " . $this->return . "\n\t";
		}

		$str .= " */\n";
		
		return $str;
	}
	
	public function render() {
		return strval($this);
	}
	
}
