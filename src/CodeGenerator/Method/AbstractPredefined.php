<?php

namespace CodeGenerator\Method;

abstract class AbstractPredefined {
	
	public $name;
	
	public $scope = 'public';
	
	public $parameters = array();
	
	public $description;
	
	public $returns;
	
	// Should return body string of method
	abstract public function getBody();
	
	// Can be overwritten
	public function __toString(){
		
		$str = '';
		
		$str .= $this->getDocblock() . "\n";
		
		$str .= "\t$this->scope function $this->name" . '(';
		
		if (! empty($this->parameters)) {
			
			foreach($this->parameters as $name => $type) {
				
				if (\CodeGenerator\Generator::isPrintableType($type)) {
					$str .= $type . ' ';
				}
				
				$str .= '$'.$name.', ';
			}
			
			$str = rtrim($str, ' ,');
		}
		
		$str .= ') {';
		
		$str .= "\n\t\t". $this->getBody() . "\n\t}";
		
		return $str;
	}
	
	// Could be overwritten
	public function getDocblock() {
			
		$s = '/** ';
		
		if (! empty($this->description)) {
			$s .= "\n\t * $this->description";
		}
		
		if (! empty($this->parameters)) {
			foreach($this->parameters as $name => $type) {
				$s .= "\n\t * @param $type $name ";
			}
		}
		
		if (! empty($this->returns)) {
			$s .= "\n\t * @return $this->returns";
		}
		
		$s .= "\n\t */";
		
		return $s;
	}
	
}
